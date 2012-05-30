<?php
abstract class BaseFileListView extends ListView
{
    public $model;
    public $tag;

    public $items;
    public $enablePagination = false;

    public $assets;

    public function init()
    {

        if ($this->dataProvider === null)
        {
            $this->dataProvider = Yii::app()->getModule('fileManager')->getDataProviderByModel($this->model, $this->tag);
        }
        if (isset($this->htmlOptions['id']))
        {
            $this->htmlOptions['id'] = get_class($this).'_'.$this->dataProvider->getId();
        }

        $this->assets  = Yii::app()->getModule('fileManager')->assetsUrl();
        parent::init();

    }

}