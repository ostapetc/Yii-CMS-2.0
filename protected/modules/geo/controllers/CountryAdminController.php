<?php

class CountryAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Create" => "Добавление страны",
            "Update" => "Редактирование страны",
            "Delete" => "Удаление страны",
            "Manage" => "Управление странами"
        );
    }


    public function actionCreate()
    {
        $model = new Country;

        $this->performAjaxValidation($model);
        $form = new BaseForm('geo.CountryForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect(array(
                    'manage',
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
        $form = new BaseForm('geo.CountryForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect(array(
                    'manage',
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
        $model = new Country('search');
        $model->unsetAttributes();
        if (isset($_GET['Country']))
        {
            $model->attributes = $_GET['Country'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }

}
