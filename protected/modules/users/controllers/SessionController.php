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
            Yii::app()->user->setFlash('success', t('Вы успешно авторизованы'));
            $this->redirect(Yii::app()->user->model->url);
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
