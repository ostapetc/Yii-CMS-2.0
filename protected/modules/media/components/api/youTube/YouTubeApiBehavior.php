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
        if ($this->getOwner()->getIsNewRecord())
        {

        }
        else
        {
            $this->getApiModel()->title = $this->getOwner()->title;
            $this->getApiModel()->description = $this->getOwner()->descr;
//            if (!$this->getApiModel()->save()) {
                //what to do??
//            }
        }
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

    /**
     * @param LocalApi $local_api
     */
    public function convertFromLocal($local_api)
    {
        $api = $this->getApiModel(false);
        $owner = $this->getOwner();
        $api->title = $owner->title;
        $api->description = $owner->descr;
        $new_api = $api->sendFile($local_api->getServerPath());

        $this->setPk($new_api->pk);
    }

    public function getPreviewArray()
    {
        $player = $this->getApiModel()->player_url;
        if ($player)
        {
            return ['type' => 'iframe', 'val' => $player];
        }
        else
        {
            return ['type' => 'img', 'val' => $this->icon];
        }
    }

    public function getPreview($size = ['width' => 128, 'height' => 128])
    {
        $conf = $this->getPreviewArray();
        if ($conf['type'] == 'iframe')
        {
            return CHtml::tag('iframe', CMap::mergeArray($size, [
                'src' => $conf['val']
            ]), '', true);
        }
    }

    public function getUrl()
    {
        throw new CException('not implemented yet');
    }

}