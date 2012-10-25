<?php
Yii::import('media.components.api.ApiBehaviorAbstract');
class LocalApiBehavior extends ApiBehaviorAbstract
{
    const UPLOAD_PATH = 'upload/media';

    public $api_map;
    public $new_record_status;
    public $old_name;

    protected $file_info;

    public function parse($content)
    {
        return false;
    }

    public function afterFind($event)
    {
        $this->file_info = new SplFileInfo($this->basePath() . $this->getPk());
    }

    public function getThumb($size, $crop = true)
    {
        $dir  = '/' . self::UPLOAD_PATH . '/' . pathinfo($this->getPk(), PATHINFO_DIRNAME);
        $name = pathinfo($this->getPk(), PATHINFO_BASENAME);
        return ImageHelper::thumbSrc($dir, $name, $size, $crop);
    }



    public function getServerDir()
    {
        return $this->basePath() . pathinfo($this->pk, PATHINFO_DIRNAME) . '/';
    }


    public function getServerPath()
    {
        return $this->basePath() . $this->pk;
    }


    /**
     * @return string formatted file size
     */
    public function getSize()
    {
        $file = $this->getServerPath();

        $size = is_file($file) ? filesize($file) : NULL;

        $metrics[0] = 'байт';
        $metrics[1] = 'кб.';
        $metrics[2] = 'мб.';
        $metrics[3] = 'гб.';
        $metric     = 0;

        while (floor($size / 1024) > 0)
        {
            ++$metric;
            $size /= 1024;
        }

        $ret = round($size, 1) . " " . (isset($metrics[$metric]) ? $metrics[$metric] : '??');
        return $ret;
    }

    public function getContent()
    {
        if (file_exists($this->getServerPath()))
        {
            return file_get_contents($this->getServerPath());
        }
    }


    public function getHref()
    {
        return '/' . self::UPLOAD_PATH . '/' . $this->pk;
    }


    public function getUrl()
    {
        //todo: see download url
        throw new CException('not implemented yet');
    }


    public function getType()
    {
        $doc = [
            'book',
            'archive',
            'word',
            'excel'
        ];
        switch (true)
        {
            case $this->typeIs($doc):
                return MediaFile::TYPE_DOC;
            case $this->typeIs('audio'):
                return MediaFile::TYPE_AUDIO;
            case $this->typeIs('video'):
                return MediaFile::TYPE_VIDEO;
            case $this->typeIs('image'):
                return MediaFile::TYPE_IMG;
        }
    }


    protected function typeIs($types)
    {
        foreach ((array)$types as $type)
        {
            if (!in_array($this->extension, FileType::${$type . 'Extensions'}))
            {
                return false;
            }
        }
        return true;
    }


    public function getPreviewArray($size = ['width' => 64, 'height' => 64])
    {
        $folder = Yii::app()->getModule('media')->assetsUrl() . '/img/icons/';
        switch (true)
        {
            case $this->typeIs('image'):
                return [
                    'type' => 'img',
                    'val'  => $this->getThumb($size)
                ];
                break;
            case $this->typeIs('audio'):
                $name = 'audio';
                break;
            case $this->typeIs('excel'):
                $name = 'excel';
                break;
            case $this->typeIs('word'):
                $name = 'word';
                break;
            case $this->typeIs('archive'):
                $name = 'rar';
                break;
            case $this->typeIs('video'):
                return [
                    'type' => 'video',
                    'val'  => ImageHelper::placeholder($size, 'Video processing', true)
                ];
                break;
            default:
                if (is_file('.' . $folder . $this->extension . '.jpg'))
                {
                    $name = $this->extension;
                }
                else
                {
                    $name = 'any';
                }
                break;
        }

        return [
            'type' => 'img',
            'val'  => $folder . $name . '.jpg'
        ];
    }


    public function getPreview($size = ['width' => 64, 'height' => 64])
    {
        $data = $this->getPreviewArray($size);

        switch ($data['type'])
        {
            case 'img':
                return CHtml::image($data['val'], '', $size);
                break;
            case 'video':
                return ImageHelper::placeholder($size, 'Video processing');
                break;
        }
    }


    public function getExtension()
    {
        return pathinfo($this->getPk(), PATHINFO_EXTENSION);
    }


    public function beforeSave($event)
    {
        $owner = $this->getOwner();
        if ($owner->getIsNewRecord())
        {
            if ($this->_save('file'))
            {
                $this->setPk($this->pk);
                $owner->title      = $this->old_name;
                $owner->type       = $this->getType();
//                $owner->target_api = $this->api_map[$owner->type];
                $owner->status     = $this->new_record_status;
                return true;
            }
            else
            {
//                $this->getOwner()->error = $this->errors;
                return false;
            }
        }
        return true;
    }


    protected function _save($key = 'file')
    {
        $file     = CUploadedFile::getInstanceByName($key);
        $new_file = $this->basePath() . $file->name;

        if ($file->saveAs($new_file))
        {
            $this->pk       = $this->moveToVault($new_file);
            $this->old_name = $file->name;
            return true;
        }
        else
        {
            $this->error = $file->getError();
            return false;
        }
    }


    public static function basePath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . self::UPLOAD_PATH . '/';
    }

    /************FileBalance***********/

    /**
     * Простой балансировщик файлов. Занимается равномерным распределением файлов по директориям.
     * Если в одной директории будет накапливаться слишком много файлов, то время поиска файла в этой директории
     * будет сильно расти.
     *
     * По умолчанию глубина вложенности подпапок $depth = 1
     * Для каждого файлы вызывается md5(uniqid(""))
     * из первых $depth*2 символов создает $depth двубуквенных директорий и файл перемещается туда .
     * За счет нормальности распределения md5(uniqid("")) файлы будут распределяться равномерно.
     * Получаем 256 возможных директорий, при количестве файлов в каждой
     * директории до 1000 файлов, не имеем проблем с производительностью.
     * Значит каждое хранилище(параметр $base_target_directory) обеспечивает быстрый доступ к 1/4 миллиона файлов.
     *
     * Накладные расходы:
     * EXT3 занимает 4КБ(служебной информации) на директорию.
     * Значит одно хранилище займет: 1мб при $depth = 1, 256мб при $depth = 2
     *
     * Возможный хранимый объем:
     * 1000 файлов по 1мб на директорию: 256ГБ при $depth = 1, 65ТБ при $depth = 2
     *
     * Устанавливать $depth больше 2-х не рекомендуется, сильно возрастают накладные расходы на хранение структуры каталогов.
     */
    public static $saveOriginalFileName = false; //если true, конечно же будут проблемы с нелатиницей, пробелами и пр.
    public static $depth = 1;


    public function moveToVault($src_file, $as_array = false)
    {
        if (!is_file($src_file))
        {
            return false;
        }


        list($target_folder, $target_file) = $this->getVaultPathAndName($src_file);

        if (!is_dir(self::basePath() . $target_folder))
        {
            @mkdir(self::basePath() . $target_folder, 0755, true);
        }

        @rename($src_file, self::basePath() . $target_folder . '/' . $target_file);

        if ($as_array)
        {
            return [
                $target_folder,
                $target_file
            ];
        }
        else
        {
            return $target_folder . '/' . $target_file;
        }
    }


    public function getVaultPathAndName($src_file, $target_file_name = null)
    {
        $id = md5(uniqid("", true));

        //from 4 symbol construct 2 folders
        $folder_id     = substr($id, 0, self::$depth * 2);
        $target_folder = implode('/', str_split($folder_id, 2));
        //new file name
        if ($target_file_name === null)
        {
            if (self::$saveOriginalFileName)
            {
                $target_file_name = pathinfo($src_file, PATHINFO_BASENAME);
            }
            else
            {
                $target_file_name =
                    substr($id, self::$depth * 2) . '.' . pathinfo($src_file, PATHINFO_EXTENSION);
            }
        }

        $target_file = $this->vaultResolveCollision($target_file_name, $target_folder);

        return [
            $target_folder,
            $target_file
        ];
    }


    public function vaultResolveCollision($file, $folder)
    {
        while (is_file(self::basePath() . $folder . '/' . $file))
        {
            $file = rand(0, 9) . $file;
        }
        return $file;
    }

}