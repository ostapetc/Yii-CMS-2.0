<?php
class Captcha extends InputWidget
{
    public function run()
    {
        echo CHtml::activeTextField($this->model, $this->attribute);
        $this->widget('Captcha', array(
            'captchaAction' => '/main/help/captcha'
        ));
    }
}
