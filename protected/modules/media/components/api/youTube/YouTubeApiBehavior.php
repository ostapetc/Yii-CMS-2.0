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

    public function getType()
    {
        return MediaFile::TYPE_VIDEO;
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
        return true;
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

    public function getPlayer($size = ['width' => 128, 'height' => 128])
    {
        $conf = $this->getPreviewArray('iframe');
        return CHtml::tag('iframe', CMap::mergeArray($size, [
            'src' => $conf['val']
        ]));
    }

    public function getPreviewArray($type = 'img')
    {
        if ($type == 'iframe')
        {
            return ['type' => 'iframe', 'val' => $this->getApiModel()->player_url];
        }
        elseif ($type == 'img')
        {
            return ['type' => 'img', 'val' => $this->getApiModel()->getThumb()];
        }
    }

    public function getPreview($size = ['width' => 128, 'height' => 128])
    {
        $conf = $this->getPreviewArray();
        return CHtml::image($conf['val'], '', []);
    }

    public function getUrl()
    {
        throw new CException('not implemented yet');
    }

}