<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 07.12.12
 * Time: 16:19
 * To change this template use File | Settings | File Templates.
 */

class SessionController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            'create'  => t('Авторизация'),
            'delete'  => t('Выход'),
        );
    }


    public function actionCreate()
    {
        $model = new User(User::SCENARIO_LOGIN);
        $form  = new Form('users.LoginForm', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->validate())
        {
            $identity = new UserIdentity($model->email, $model->password);
            if ($identity->authenticate())
            {
                Yii::app()->user->setFlash('success', t('Вы успешно авторизованы'));
                $this->redirect(Yii::app()->user->model->url);
            }
            else
            {
                $auth_error = $identity->errorCode;
                if ($auth_error == UserIdentity::ERROR_NOT_ACTIVE)
                {
                    $auth_error.= '<br/>' . CHtml::link('Не пришло письмо? Активировать аккаунт повторно?', '/activateAccountReques');
                }
                else if ($auth_error == UserIdentity::ERROR_UNKNOWN)
                {
                    $auth_error.= '<br/>' . CHtml::link('Восстановить пароль', 'changePasswordRequest');
                }

                Yii::app()->user->setFlash('error', $auth_error);

                $this->redirect('/login');
            }
        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionDelete()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}
