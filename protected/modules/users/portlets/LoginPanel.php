<?php
class LoginPanel extends Widget
{
    public function run()
    {
        if (Yii::app()->user->isGuest)
        {
            $login_form    = new BaseForm('users.LoginForm', new User(User::SCENARIO_LOGIN));
            $register_form = new BaseForm('users.RegistrationForm', new User(User::SCENARIO_REGISTRATION));
            $forgot_form   = new BaseForm('users.PasswordRecoverRequestForm', new User(User::SCENARIO_CHANGE_PASSWORD_REQUEST));

            $title = 'Вход';
            $this->render('LoginPanel', array(
                'title'          => $title,
                'login_form'     => $login_form,
                'register_form'  => $register_form,
                'forgot_form'    => $forgot_form,
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