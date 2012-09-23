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
                'width'  => 48,
                'height' => 48
            );
        }
        $a = ImageHelper::thumb($this->getServerDir(), pathinfo($this->getPk(), PATHINFO_BASENAME), $size,
            $crop)->__toString();
        return $a;
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
        switch (true)
        {
            case $this->isDocument:
                return self::TYPE_DOC;
            case $this->isAudio:
                return self::TYPE_AUDIO;
            case $this->isVideo:
                return self::TYPE_VIDEO;
            case $this->isImage:
                return self::TYPE_IMG;
        }
    }


    protected function isType($type)
    {
        return in_array($this->extension, LocalFileExtensions::${$type . 'Extensions'});
    }


    public function getIcon()
    {
        $folder = $this->assets . '/img/fileIcons/';
        switch (true)
        {
            case $this->isImage:
                return $this->getThumb();
                break;
            case $this->isAudio:
                $name = 'audio';
                break;
            case $this->isExcel:
                $name = 'excel';
                break;
            case $this->isWord:
                $name = 'word';
                break;
            case $this->isArchive:
                $name = 'rar';
                break;
            default:
                $name = is_file('.' . $folder . $this->extension . '.jpg') ? $this->extension : 'any';
                break;
        }

        return CHtml::image($folder . $name . '.jpg', '', array('height' => 48));
    }


    public function getExtension()
    {
        return pathinfo($this->getPk(), PATHINFO_EXTENSION);
    }


    public function getIsImage()
    {
        return $this->isType('image');
    }


    public function getIsAudio()
    {
        return $this->isType('audio');
    }


    public function getIsExcel()
    {
        return $this->isType('excel');
    }


    public function getIsWord()
    {
        return $this->isType('word');
    }


    public function getIsVideo()
    {
        return $this->isType('video');
    }


    public function getIsArchive()
    {
        return $this->isType('archive');
    }


    public function getIsDocument()
    {
        return $this->isType('readable') || $this->isArchive || $this->isWord || $this->isExcel;
    }


    public function getIsFileExist()
    {
        $this->getApiModel()->getIsFileExists();
    }


    public function beforeSave($event)
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

}