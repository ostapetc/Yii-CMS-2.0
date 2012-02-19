<?php
class ChosenWidget extends Widget
{
    public $items;
    public $name;
    public $current;
    public $htmlOptions;
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