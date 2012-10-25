<?php
Yii::import('media.components.api.ApiBehaviorAbstract');
class RemoteApiBehavior extends ApiBehaviorAbstract
{
    public $new_record_status;



    public function parse($content)
    {
        return false;
    }

    public function getThumb($size = null, $crop = true)
    {
        if (is_string($size))
        {
            $size = $this->getSize($size);
        }

        $dir  = pathinfo($this->getPk(), PATHINFO_DIRNAME);
        $name = pathinfo($this->getPk(), PATHINFO_BASENAME);
        return ImageHelper::thumb($dir, $name, $size, $crop)->getSrc();
    }


    public function getHref()
    {
        return $this->pk;
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


    public function getPreviewArray($size_name = null)
    {
        $folder = Yii::app()->getModule('media')->assetsUrl() . '/img/icons/';
        switch (true)
        {
            case $this->typeIs('image'):
                return [
                    'type' => 'img',
                    'val'  => $this->getThumb()
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
                    'val'  => ImageHelper::placeholder($this->getSize($size_name), 'Video processing', true)
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


    public function getPreview($size_name = null)
    {
        $data = $this->getPreviewArray($size_name);

        switch ($data['type'])
        {
            case 'img':
                return CHtml::image($data['val']);
                break;
            case 'video':
                return ImageHelper::placeholder($this->getSize($size_name), 'Video processing');
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
            $this->setPk($this->pk);
            $owner->type   = $this->getType();
            $owner->status = $this->new_record_status;
            return true;
        }
        return true;
    }

}