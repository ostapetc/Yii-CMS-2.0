<?php
class LoginPanel extends Widget
{
    const CACHE_ID = 'LoginPanel';

    public function run()
    {
        if (Yii::app()->user->isGuest)
        {
            $login_form    = new BaseForm('users.LoginForm', new User(User::SCENARIO_LOGIN));
            $register_form = new BaseForm('users.RegistrationForm', new User(User::SCENARIO_REGISTRATION));
            $forgot_form   = new BaseForm('users.PasswordRecoverRequestForm', new User(User::SCENARIO_CHANGE_PASSWORD_REQUEST));


            $title = 'Вход';

            if ($res = Yii::app()->cache->get(self::CACHE_ID))
            {
                return $res;
            }

            $res = $this->render('LoginPanel', array(
                'title'          => $title,
                'login_form'     => $login_form,
                'register_form'  => $register_form,
                'forgot_form'    => $forgot_form,
            ), true);
            Yii::app()->cache->set(self::CACHE_ID, $res, 60);
            echo $res;
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