<?php
class MediaYouTubeApi extends MediaApiAbstract
{
    const UPLOAD_PATH = 'upload/mediaFiles';

    protected $fileInfo;


    public function findAll($criteria)
    {

    }


    function count($criteria)
    {

    }


    public function findByPk($pk)
    {
        $this->beforeFind();
        $file = new SplFileInfo(Yii::getPathOfAlias('webroot') . '/' . self::UPLOAD_PATH . '/' . $pk);
        return $this->populateRecord($file);
    }


    public function saveFile($key = 'file')
    {
        $file      = CUploadedFile::getInstanceByName($key);
        $file_name = $this->vaultResolveCollision($file->name);
        $new_file  = self::UPLOAD_PATH . '/' . $file_name;

        if ($file->saveAs(Yii::getPathOfAlias('webroot') . '/' . $new_file))
        {
            list($this->path, $this->name) = $this->moveToVault($new_file, true);
            $this->title = $file->name;
            return true;
        }
        else
        {
            $this->error = $file->getError();
            return false;
        }
    }


    public $path;
    public $name;


    /**
     * @param $fileInfo SplFileInfo
     */
    protected function _populate($fileInfo)
    {
//        $this->pk = $fileInfo
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

        list($target_path, $target_file) = self::getVaultPathAndName($src_file, $base_vault_directory);

        if (!is_dir('./' . $target_path))
        {
            @mkdir('./' . $target_path, 0755, true);
        }

        @rename('./' . $src_file, './' . $target_path . '/' . $target_file);

        if ($as_array)
        {
            return array(
                $target_path,
                $target_file
            );
        }
        else
        {
            return $target_path . '/' . $target_file;
        }
    }


    public function getVaultPathAndName($src_file, $base_vault_directory, $target_file_name = null)
    {
        $id = md5(uniqid("", true));

        //from 4 symbol construct 2 folders
        $folder_id = substr($id, 0, self::$depth * 2);
        $folder_id = implode('/', str_split($folder_id, 2));
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

        $target_path = $base_vault_directory . '/' . $folder_id;
        $target_file = self::vaultResolveCollision($target_path, $target_file_name);

        return array(
            $target_path,
            $target_file
        );
    }


    public function vaultResolveCollision($file)
    {
        while (is_file('./' . self::UPLOAD_PATH . '/' . $file))
        {
            $file = rand(0, 9) . $file;
        }
        return $file;
    }


}