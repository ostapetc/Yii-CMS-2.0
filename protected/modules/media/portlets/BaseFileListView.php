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
            $this->dataProvider = MediaFile::getDataProvider($this->model, $this->tag);
            $this->dataProvider->pagination = false;
        }

        $this->assets  = Yii::app()->getModule('media')->assetsUrl();
        parent::init();
    }


}