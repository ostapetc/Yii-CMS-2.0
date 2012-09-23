<?php
Yii::import('media.components.api.abstract.*');
Yii::import('media.components.api.youTube.*');
class YouTubeApiBehavior extends ApiBehaviorAbstract
{
    public $icon;


    public function getThumb()
    {
        throw new CException('not implemented yet');
    }


    public function getServerDir()
    {
        throw new CException('not implemented yet');
    }


    public function getHref()
    {
        throw new CException('not implemented yet');
    }


    public function getIcon()
    {
        return $this->assets . '/' . $this->icon;
    }


    public function getUrl()
    {
        throw new CException('not implemented yet');
    }

}