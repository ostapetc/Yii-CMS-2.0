<?php
class LoginPanel extends Portlet
{
    public function init()
    {
        parent::init();
    }

    public function renderContent()
    {
        if (Yii::app()->user->isGuest)
        {
            $model = new User(User::SCENARIO_LOGIN);
            echo new BaseForm('users.LoginForm', $model);
        }
        else
        {
            $this->render('LoginPanel');
        }
    }

}