<?php

class FaqAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "View"             => "Просмотр вопроса",
            "Create"           => "Добавление вопроса",
            "Update"           => "Редактирование вопроса",
            "Delete"           => "Удаление вопроса",
            "Manage"           => "Управление вопросами",
            "SendNotification" => "Отправить уведомление"
        );
    }


    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }


    public function actionCreate()
    {
        $model = new Faq;

        $this->performAjaxValidation($model);
        $form = new BaseForm('faq.FaqForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect(array(
                    'view',
                    'id' => $model->id
                ));
            }
        }

        $this->render('create', array(
            'form' => $form,
        ));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);
        $form = new BaseForm('faq.FaqForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect(array(
                    'view',
                    'id'=> $model->id
                ));
            }
        }

        $this->render('update', array(
            'form' => $form,
        ));
    }


    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }


    public function actionManage()
    {
        $model = new Faq('search');
        $model->unsetAttributes();
        if (isset($_GET['Faq']))
        {
            $model->attributes = $_GET['Faq'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }

    public function actionSendNotification($id)
    {
        $model = $this->loadModel($id);
        if (!$model->email)
        {
            echo 'Неверный email';
            Yii::app()->end();
        }

        $body  = $this->renderPartial('notification', array('model'=> $model), true);
        $title = 'Отзыв с сайта ' . Yii::app()->request->hostInfo;
        $email = $model->email;
        Yii::app()->getModule('mailer')->sendMail($email, $title, $body, true);

        $model->notification_send = 1;
        $model->notification_date = date('Y-m-d h:i:s');
        $model->save();
        $this->redirect($model->manageUrl);
    }
}
