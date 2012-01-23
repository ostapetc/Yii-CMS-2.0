<?php
class IphoneCheckbox extends InputWidget
{
    public $type = 'checkbox';
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
            ->registerScriptFile('/js/plugins/adminForm/checkbox/iphone-style-checkboxes.js')
            ->registerCssFile('/js/plugins/adminForm/checkbox/style.css')->registerScript(
            $this->id . '_iphone_checkbox', "$('#{$this->id}').iphoneStyle($options);");
    }


    public function run()
    {
        $attributes = array();
        if ($this->checked !== null)
        {
            $attributes['checked'] = $this->checked;
        }

        $el = new FormInputElement(array(
            'type' => $this->type,
            'name' => $this->attribute,
            'attributes' => $attributes,
        ), $this);
        echo $el->renderInput();
    }
}