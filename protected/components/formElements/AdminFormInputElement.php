<?php
class AdminFormInputElement extends CFormInputElement
{
    public static $widgets = array(
        'alias'             => 'AliasField',
        'all_in_one_input'  => 'AllInOneInput',
        'multi_select'      => 'EMultiSelect',
        'date'              => 'FJuiDatePicker',
        'checkbox'          => 'IphoneCheckbox',
        'multi_autocomplete'=> 'MultiAutocomplete',
        'editor'            => 'TinyMCE',
        'autocomplete'      => 'zii.widgets.jui.CAutoComplete',
    );

    public static $default_widget_settings = array(
        'alias'             => array('class' => 'text'),
        'date'              => array(
            'options'  => array('dateFormat'=> 'd.m.yy'),
            'language' => 'ru'
        ),
        'autocomplete'      => array(
            'minChars'   => 2,
            'delay'      => 500,
            'matchCase'  => false,
            'htmlOptions'=> array(
                'size'  => '40',
                'class' => 'text'
            )
        )
    );

    public $widgets_path = 'application.components.formElements';


    public function renderInput()
    {
        //set default settings
        if (isset(self::$default_widget_settings[$this->type]))
        {
            $this->attributes = CMap::mergeArray(self::$default_widget_settings[$this->type], $this->attributes);
        }

        //replace sinonym on full alias
        if (isset(self::$widgets[$this->type]))
        {
            $this->type = $this->widgets_path . str_repeat('.' . self::$widgets[$this->type], 2);
        }
        return parent::renderInput();
    }
}