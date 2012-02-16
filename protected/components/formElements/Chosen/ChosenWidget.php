<?php
class ChosenWidget extends Widget
{
    public $items;
    public $name;
    public $current;
    public $htmlOptions;


    public function init()
    {
        parent::init();
        $options = CJavaScript::encode(array(
            'no_results_text'      => "Выберите один из вариантов",
            'allow_single_deselect'=> true
        ));

        $assets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.components.formElements.Chosen.assets'));
        Yii::app()->clientScript->registerScriptFile($assets . '/chosen.jquery.js')->registerCssFile(
            $assets . '/chosen.css')->registerScript(
            $this->id . '_chosen', "$('#{$this->id}').chosen($options);");
    }


    public function run()
    {
        if (!isset($this->htmlOptions['id']))
        {
            $this->htmlOptions['id'] = $this->id;
        }

        echo CHtml::dropDownList($this->name, $this->current, $this->items, $this->htmlOptions);
    }
}