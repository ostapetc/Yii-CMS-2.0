<?
class IphoneCheckbox extends InputWidget
{
    public $type = 'iphone_checkbox';
    public $checkedLabel = 'Да';
    public $uncheckedLabel = 'Нет';
    public $onChange = 'Tiny';
    public $checked;


    public function init()
    {
        parent::init();
        $options = CJavaScript::encode(array(
            'checkedLabel'   => $this->checkedLabel,
            'uncheckedLabel' => $this->uncheckedLabel,
            'onChange'       => $this->onChange,
        ));

        Yii::app()->clientScript
            ->registerScriptFile($this->assets . '/iphone-style-checkboxes.js')
            ->registerCssFile($this->assets . '/style.css')->registerScript(
            $this->id . '_iphone_checkbox', "$('#{$this->id}').iphoneStyle($options);");
    }


    public function run()
    {
        echo CHtml::activeCheckBox($this->model, $this->attribute, $this->htmlOptions);
    }
}