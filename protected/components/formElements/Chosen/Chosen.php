<?php
class Chosen extends InputWidget
{
    public $items;

    public $type = 'dropdownlist';

    public function init()
    {
        parent::init();

        Yii::app()->clientScript
            ->registerScriptFile($this->assets . '/chosen.jquery.js')
            ->registerCssFile($this->assets . '/chosen.css');
    }

    public function run()
    {
        echo CHtml::activeDropDownList($this->model, $this->attribute, $this->input_element->items, $this->input_element->attributes);
    }
}