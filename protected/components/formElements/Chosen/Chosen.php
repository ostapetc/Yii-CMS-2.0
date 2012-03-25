<?
class Chosen extends InputWidget
{
    public $name;
    public $current;
    public $htmlOptions;
    public $onchange = 'js:function() {}';
    public $empty = '';


    public function init()
    {
        parent::init();
        $options = CJavaScript::encode(array(
            'no_results_text'      => "Выберите один из вариантов",
            'allow_single_deselect'=> true,
            'onChange'             => $this->onchange
        ));

        Yii::app()->clientScript->registerScriptFile($this->assets . '/chosen.jquery.js')->registerCssFile(
            $this->assets . '/chosen.css')->registerScript(
            $this->id . '_chosen', "$('#{$this->id}').chosen($options);");
    }


    public function run()
    {
        if (!isset($this->htmlOptions['id']))
        {
            $this->htmlOptions['id'] = $this->id;
        }
        if (!isset($this->htmlOptions['empty']))
        {
            $this->htmlOptions['empty'] = $this->empty;
        }

        echo CHtml::dropDownList($this->name, $this->current, $this->input_element->items, $this->input_element->attributes);
    }
}
