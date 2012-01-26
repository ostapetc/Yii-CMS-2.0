<?php
class FormInputElement extends CFormInputElement
{
    public static $widgets = array(
        'alias'             => 'AliasField',
        'AllInOneInput'     => 'AllInOneInput',
        'multi_select'      => 'EMultiSelect',
        'date'              => 'FJuiDatePicker',
        'checkbox'          => 'IphoneCheckbox',
        'multi_autocomplete'=> 'MultiAutocomplete',
        'editor'            => 'TinyMce',
    );

    public $widgets_folder = 'application.components.formElements';


    public function renderInput()
    {
        if (isset(self::$widgets[$this->type]))
        {
            $this->type = $this->widgets_folder . str_repeat('.'.self::$widgets[$this->type], 2);
        }
        parent::renderInput();
    }

}