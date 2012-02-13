<?php

class LanguageAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Create" => "Добавление языка",
            "Update" => "Редактирование языка",
            "Delete" => "Удаление языка",
            "Manage" => "Управление языками"
        );
    }


    public function actionCreate()
    {
        $model = new Language;

        $this->performAjaxValidation($model);
        $form = new BaseForm('main.LanguageForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect($this->createUrl('manage'));
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
        $form = new BaseForm('main.LanguageForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect($this->createUrl('manage'));
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
        $model = new Language('search');
        $model->unsetAttributes();
        if (isset($_GET['Language']))
        {
            $model->attributes = $_GET['Language'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }

}
