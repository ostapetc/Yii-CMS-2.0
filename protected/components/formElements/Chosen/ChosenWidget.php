<?
class ChosenWidget extends Widget
{
    public $name;
    public $current;
    public $htmlOptions;
    public $onchange = 'js:function() {}';
    public $empty = '';
    public $items = array();

    public function init()
    {
        parent::init();
        $assets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.components.formElements.Chosen.assets'));

        Yii::app()->clientScript
            ->registerScriptFile($assets . '/chosen.jquery.js')
            ->registerCssFile($assets . '/chosen.css');
    }


    public function run()
    {
        echo CHtml::dropDownList($this->name, $this->current, $this->items, $this->htmlOptions);
    }
}