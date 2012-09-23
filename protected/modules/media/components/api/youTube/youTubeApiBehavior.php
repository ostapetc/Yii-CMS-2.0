<?php
Yii::import('media.components.api.abstract.*');
Yii::import('media.components.api.youTube.*');
class YouTubeApiBehavior extends ApiBehaviorAbstract
{
    public function getThumb()
    {
    }


    public function getServerDir()
    {
    }


    public function getHref()
    {
    }


    public function getUrl()
    {

    }

    /**
     * @param $event CModelEvent
     */
    public function afterFind($event)
    {
        $this->getOwner()->api_model = $this->getApiModel()->findByPk($this->getPk());
    }

}