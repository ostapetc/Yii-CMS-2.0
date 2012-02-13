<?php

class MailerTemplateAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Добавление шаблона рассылки',
            'View'   => 'Просмотр шаблона рассылки',
            'Update' => 'Редактирование шаблона рассылки',
            'Manage' => 'Управление шаблонами рассылки',
            'Delete' => 'Удаление шаблона рассылки'
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
        $model = new MailerTemplate;

        $this->performAjaxValidation($model);
        $form = new BaseForm('mailer.MailerTemplateForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                if (isset($_POST['users_ids']))
                {
                    $model->addRecipients($_POST['users_ids']);
                }

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
        $form = new BaseForm('mailer.MailerTemplateForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $model->deleteRecipients();

                if (isset($_POST['users_ids']))
                {
                    $model->addRecipients($_POST['users_ids']);
                }

                $this->redirect(array(
                    'view',
                    'id' => $model->id
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
        $model = new MailerTemplate('search');
        $model->unsetAttributes();
        if (isset($_GET['MailerTemplate']))
        {
            $model->attributes = $_GET['MailerTemplate'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }
}
