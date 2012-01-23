<?php

class ActionAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "View"   => "Просмотр мероприятия",
            "Create" => "Добавление мероприятия",
            "Update" => "Редактирование мероприятия",
            "Delete" => "Удаление мероприятия",
            "Manage" => "Управление мероприятиями",
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
        $model = new Action;

        $form = new BaseForm('actions.ActionForm', $model);
        $this->performAjaxValidation($model);

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

        $form = new BaseForm('actions.ActionForm', $model);
        $this->performAjaxValidation($model);

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
        $model = new Action('search');
        $model->unsetAttributes();
        if (isset($_GET['Action']))
        {
            $model->attributes = $_GET['Action'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }


    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'action-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
