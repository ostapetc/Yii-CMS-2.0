<?php
Yii::import('media.components.api.abstract.*');
Yii::import('media.components.api.youTube.*');

/**
 * @method YouTubeApi getApiModel
 */
class YouTubeApiBehavior extends ApiBehaviorAbstract
{
    public $icon;
    public $href;

    public function getThumb()
    {
        throw new CException('not implemented yet');
    }


    public function getServerDir()
    {
        throw new CException('not implemented yet');
    }

    public function beforeSave($event)
    {
        $model = $this->getApiModel()->findByPk($this->getPk());
        $this->setApiModel($model);
        return true;
    }


    public function detectType()
    {
        return 'video';
    }

    public function getHref()
    {
        return $this->href;
    }


    public function getPreview()
    {
        $player = $this->getApiModel()->player_url;
        if ($player)
        {
            return "<iframe src='".$player."' width='100%' > </iframe>";
        }
        else
        {
            return "<img src='".$this->icon."' alt='' width='100%' />";
        }
    }


    public function getUrl()
    {
        throw new CException('not implemented yet');
    }

}