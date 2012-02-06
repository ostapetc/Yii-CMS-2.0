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
            $model    = new User(User::SCENARIO_LOGIN);
            $login    = new BaseForm('users.LoginForm', $model);
            $register = new BaseForm('users.RegistrationForm', $model);
            $forgot   = new BaseForm('users.PasswordRecoverRequestForm', $model);

            $title = 'Вход';
            $this->render('LoginPanel', array(
                'title'     => $title,
                'login'     => $login,
                'register'  => $register,
                'forgot'    => $forgot,
            ));
        }
        else
        {
            $content = 'Привет, ' . Yii::app()->user->model->email;
            $title   = 'Кабинет';
            $this->render('Cabinet', array(
                'content'=> $content,
                'title'  => $title
            ));
        }
    }
}