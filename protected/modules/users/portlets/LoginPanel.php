<?php
class LoginPanel extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        echo Yii::app()->user->isGuest ? 'Login' : 'Cabinet';

        if (Yii::app()->user->isGuest)
        {
            $model = new User(User::SCENARIO_LOGIN);
            $content = new BaseForm('users.LoginForm', $model);
        }
        else
        {
            $content = 'Привет, '.Yii::app()->user->model->email;
        }
        $this->render('LoginPanel', array('content'=>$content));
    }

}