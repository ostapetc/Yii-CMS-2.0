<?php
class ClientFormInputElement extends BaseFormInputElement
{
    public $widgets = array(
        'captcha'           => 'Captcha',
        'date'              => 'FJuiDatePicker',

    );


    public function getDefaultWidgetSettings()
    {
        switch ($this->type)
        {
            case 'date':
                return array(
                    'options'    => array(
                        'dateFormat'=> 'd.m.yy'
                    ),
                    'language'   => 'ru',
                    'htmlOptions'=> array('class'=> 'date text date_picker')
                );
            default:
                return array(
                    'class' => $this->type
                );
        }
    }
}
