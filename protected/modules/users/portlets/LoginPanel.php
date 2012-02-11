<?php
class LoginPanel extends Widget
{
    public function run()
    {
        if (Yii::app()->user->isGuest)
        {
            $login    = new BaseForm('users.LoginForm', new User(User::SCENARIO_LOGIN));
            $register = new BaseForm('users.RegistrationForm', new User(User::SCENARIO_REGISTRATION));
            $forgot   = new BaseForm('users.PasswordRecoverRequestForm', new User(User::SCENARIO_CHANGE_PASSWORD_REQUEST));

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