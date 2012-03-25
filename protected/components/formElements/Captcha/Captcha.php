<?
class Captcha extends InputWidget
{

    public function run()
    {
        echo CHtml::activeTextField($this->model, $this->attribute, array('id'=>$this->id));
        $this->widget('CCaptcha', array(
            'captchaAction' => '/main/help/captcha'
        ));
    }
}
