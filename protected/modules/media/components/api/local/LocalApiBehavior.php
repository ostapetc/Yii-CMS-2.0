<?php
Yii::import('media.components.api.abstract.*');
Yii::import('media.components.api.local.*');
class LocalApiBehavior extends ApiBehaviorAbstract
{
    const TYPE_IMG   = 'img';
    const TYPE_VIDEO = 'video';
    const TYPE_AUDIO = 'audio';
    const TYPE_DOC   = 'doc';

    public $types = array(
        self::TYPE_IMG   => self::TYPE_IMG,
        self::TYPE_VIDEO => self::TYPE_VIDEO,
        self::TYPE_AUDIO => self::TYPE_AUDIO,
        self::TYPE_DOC   => self::TYPE_DOC,
    );

    public $api_map;
    public $new_record_status;


    public function getThumb($size, $crop = true)
    {
        $dir  = '/' . LocalApi::UPLOAD_PATH . '/' . pathinfo($this->getPk(), PATHINFO_DIRNAME);
        $name = pathinfo($this->getPk(), PATHINFO_BASENAME);
        return ImageHelper::thumbSrc($dir, $name, $size, $crop);
    }


    public function getServerPath()
    {
        return $this->getApiModel()->getServerPath();
    }


    public function getServerDir()
    {
        return $this->getApiModel()->getServerDir();
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
        return '/' . LocalApi::UPLOAD_PATH . '/' . $this->pk;
    }


    public function getUrl()
    {
        //todo: see download url
        throw new CException('not implemented yet');
    }


    public function detectType()
    {
        $doc = array(
            'book',
            'archive',
            'word',
            'excel'
        );
        switch (true)
        {
            case $this->typeIs($doc):
                return self::TYPE_DOC;
            case $this->typeIs('audio'):
                return self::TYPE_AUDIO;
            case $this->typeIs('video'):
                return self::TYPE_VIDEO;
            case $this->typeIs('image'):
                return self::TYPE_IMG;
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


    public function getPreviewArray($size = array('width' => 64, 'height' => 64))
    {
        $folder = Yii::app()->getModule('media')->assetsUrl() . '/img/icons/';
        switch (true)
        {
            case $this->typeIs('image'):
                return array(
                    'type' => 'img',
                    'val'  => $this->getThumb($size)
                );
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
                return array(
                    'type' => 'video',
                    'val'  => ImageHelper::placeholder($size, 'Video processing', true)
                );
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

        return array(
            'type' => 'img',
            'val'  => $folder . $name . '.jpg'
        );
    }


    public function getPreview($size = null)
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


    public function getIsFileExist()
    {
        $this->getApiModel()->getIsFileExists();
    }


    public function beforeSave($event)
    {
        $owner = $this->getOwner();
        if ($owner->getIsNewRecord())
        {
            if ($this->getApiModel(false)->save('file'))
            {
                $this->setPk($this->getApiModel()->pk);
                $owner->title      = $this->getApiModel()->old_name;
                $owner->type       = $this->detectType();
                $owner->target_api = $this->api_map[$owner->type];
                $owner->status     = $this->new_record_status;
                return true;
            }
            else
            {
//                $this->getOwner()->error = $this->getApiModel()->errors;
                return false;
            }
        }
        return true;
    }

}