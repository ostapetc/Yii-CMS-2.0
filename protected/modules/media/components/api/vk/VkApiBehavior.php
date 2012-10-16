<?php
Yii::import('media.components.api.abstract.*');
Yii::import('media.components.api.youTube.*');

/**
 * @method YouTubeApi getApiModel
 */
class VkApiBehavior extends ApiBehaviorAbstract
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


    public function detectType()
    {
        return 'video';
    }


    public function getHref()
    {
        return $this->href;
    }


    public function beforeSave($event)
    {
        $model = $this->getApiModel()->findByPk($this->getPk());
        $this->setApiModel($model);
        return true;
    }


    public function getPreviewArray()
    {
        $player = $this->getApiModel()->getPlayerUrl();
        if ($player)
        {
            return [
                'type' => 'iframe',
                'val'  => $player
            ];
        }
        else
        {
            return [
                'type' => 'img',
                'val'  => $this->icon
            ];
        }
    }


    public function getPreview($size_name = null)
    {

    }


    public function getUrl()
    {
        throw new CException('not implemented yet');
    }

}