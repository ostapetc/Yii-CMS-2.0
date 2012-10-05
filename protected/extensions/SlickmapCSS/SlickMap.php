<?php
Yii::import('zii.widgets.CMenu');
class SlickMap extends CMenu
{
    protected $assets;

    public $column_count = 6;

    public function init()
    {
        $this->assets = Yii::app()->assetManager->publish(__DIR__ . '/assets/');
        Yii::app()->clientScript->registerCssFile($this->assets . '/slickmap.css');
        $this->htmlOptions= array(
            'class' => 'col'.$this->column_count,
            'id' => 'primaryNav'
        );

        $this->items[0]['itemOptions'] = array('id' => 'home');
    }

}