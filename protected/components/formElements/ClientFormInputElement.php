<?php
class ClientFormInputElement extends BaseFormInputElement
{
    public static $widgets = array(
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
