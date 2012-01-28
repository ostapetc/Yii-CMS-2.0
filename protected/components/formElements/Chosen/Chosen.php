<?php
class Chosen extends InputWidget
{
    public $items;

    public $type = 'dropdownlist';

    public function init()
    {
        parent::init();
        $options = CJavaScript::encode(array(
            'no_results_text'      => "Выберите один из вариантов",
            'allow_single_deselect'=> true
        ));

        Yii::app()->clientScript
            ->registerScriptFile($this->assets . '/chosen.jquery.js')
            ->registerCssFile($this->assets . '/chosen.css')
            ->registerScript($this->id . '_chosen', "$('#{$this->id}').chosen($options);");
    }

    public function run()
    {
        echo CHtml::activeDropDownList($this->model, $this->attribute, $this->input_element->items, $this->input_element->attributes);
    }
}