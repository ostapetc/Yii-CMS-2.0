<?php
class ClientFormInputElement extends BaseFormInputElement
{
    public $widgets = array(
        'captcha' => 'Captcha',
    );


    public function getDefaultWidgetSettings()
    {
        switch ($this->type)
        {
            default:
                return array(
                    'class' => $this->type
                );
        }
    }
}
