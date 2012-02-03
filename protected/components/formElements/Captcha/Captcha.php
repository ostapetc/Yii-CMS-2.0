<?php
class Captcha extends InputWidget
{
    public function run()
    {
        echo CHtml::activeTextField($this->model, $this->attribute);
        $this->widget('CCaptcha', array(
            'captchaAction' => '/main/help/captcha'
        ));
    }
}
