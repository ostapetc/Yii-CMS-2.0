<?php
Yii::import('media.components.api.abstract.*');
Yii::import('media.components.api.local.*');
class LocalApiBehavior extends ApiBehaviorAbstract
{
    const FILE_POSTFIX = '';

    const TYPE_IMG     = 'img';
    const TYPE_VIDEO   = 'video';
    const TYPE_AUDIO   = 'audio';
    const TYPE_DOC     = 'doc';

    public $types = array(
        self::TYPE_IMG   => self::TYPE_IMG,
        self::TYPE_VIDEO => self::TYPE_VIDEO,
        self::TYPE_AUDIO => self::TYPE_AUDIO,
        self::TYPE_DOC   => self::TYPE_DOC,
    );

    protected $file_info;

    public $api_model;


    /**
     * @return MediaApiAbstract
     */
    public function getApiModel()
    {
        $owner = $this->getOwner();
        if ($owner->api_model === null)
        {
            $owner->api_model = Yii::createComponent($this->api_model);
        }
        return $owner->api_model;
    }


    public function getThumb()
    {
        return ImageHelper::thumb($this->getServerDir(),
            pathinfo($this->getOwner()->remote_id, PATHINFO_BASENAME), array(
                'width'  => 48,
                'height' => 48
            ), true)->__toString();
    }


    public function getServerDir()
    {
        return $_SERVER['DOCUMENT_ROOT'] . pathinfo($this->getOwner()->remote_id, PATHINFO_DIRNAME) . '/';
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


    public function getHref()
    {
        return '/' . LocalApi::UPLOAD_PATH . '/' . $this->getOwner()->remote_id;
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
        return pathinfo($this->getOwner()->remote_id, PATHINFO_EXTENSION);
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
        $filename =
            Yii::getPathOfAlias('webroot') . '/' . LocalApi::UPLOAD_PATH . '/' . $this->getOwner()->remote_id;
        return file_exists($filename) && is_file($filename);
    }


    /**
     * @param $event CModelEvent
     */
    public function afterFind($event)
    {
        $this->getOwner()->api_model = $this->getApiModel()->findByPk($event->sender->remote_id);
    }


    public function beforeSave($event)
    {
        if ($this->getApiModel()->save('file'))
        {
            $this->getOwner()->remote_id = $this->moveToVault($new_file);
            $this->getOwner()->title     = $file->name;
            return true;
        }
        else
        {
            $this->error = $this->getApiModel()->error;
        }
    }

}