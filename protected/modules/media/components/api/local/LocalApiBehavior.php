<?php
Yii::import('media.components.api.abstract.*');
Yii::import('media.components.api.local.*');
class LocalApiBehavior extends ApiBehaviorAbstract
{
    const FILE_POSTFIX = '';

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

    protected $file_info;


    public function getThumb()
    {
        $a = ImageHelper::thumb($this->getServerDir(), pathinfo($this->getPk(), PATHINFO_BASENAME), array(
            'width'  => 48,
            'height' => 48
        ), true)->__toString();
        return $a;
    }


    public function getServerDir()
    {
        return LocalApi::UPLOAD_PATH . '/' . pathinfo($this->getPk(), PATHINFO_DIRNAME) . '/';
    }


    public function getHref()
    {
        return '/' . LocalApi::UPLOAD_PATH . '/' . $this->getPk();
    }


    public function getUrl()
    {

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
        $folder = Yii::app()->getModule('media')->assetsUrl() . '/img/fileIcons/';
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
        $filename = Yii::getPathOfAlias('webroot') . '/' . LocalApi::UPLOAD_PATH . '/' . $this->getPk();
        return file_exists($filename) && is_file($filename);
    }


    /**
     * @param $event CModelEvent
     */
    public function afterFind($event)
    {
        $this->getOwner()->api_model = $this->getApiModel()->findByPk($this->getPk());
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
            $this->error = $this->getApiModel()->error;
            return false;
        }
    }

}