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


    public function getThumb($size = null, $crop = true)
    {
        if (!$size)
        {
            $size = array(
                'width'  => 128,
//                'height' => 200
            );
        }

        $dir  = '/' . LocalApi::UPLOAD_PATH . '/' . pathinfo($this->getPk(), PATHINFO_DIRNAME);
        $name = pathinfo($this->getPk(), PATHINFO_BASENAME);
        return ImageHelper::thumb($dir, $name, $size, $crop)->getSrc();
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
        if (file_exists($ths->getServerPath()))
        {
            return file_get_contents($ths->getServerPath());
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
            'readable',
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
            if (!in_array($this->extension, LocalFileExtensions::${$type . 'Extensions'}))
            {
                return false;
            }
        }
        return true;
    }


    public function getPreview()
    {
        $folder = $this->assets . '/img/icons/';
        switch (true)
        {
            case $this->typeIs('image'):
                return array('type' => 'img', 'val' => $this->getThumb());
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
            default:
                $name = is_file('.' . $folder . $this->extension . '.jpg') ? $this->extension : 'any';
                break;
        }
        return array('type' => 'img', 'val' => $folder . $name . '.jpg');
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
        if ($this->getOwner()->getIsNewRecord())
        {
            if ($this->getApiModel()->save('file'))
            {
                $this->setPk($this->getApiModel()->pk);
                $this->getOwner()->title = $this->getApiModel()->old_name;
                return true;
            }
            else
            {
                $this->getOwner()->error = $this->getApiModel()->error;
                return false;
            }
        }
        return true;
    }

}