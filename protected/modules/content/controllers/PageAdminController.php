<?php

class PageAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Manage"      => t("Управление страницами"),
            "Create"      => t("Добавление страницы"),
            "View"        => t("Просмотр страницы"),
            "Update"      => t("Редактирование страницы"),
            "Delete"      => t("Удаление страницы"),
            "GetJsonData" => t("Получение данных страницы (JSON)")
        );
    }


    public function actionManage()
    {
        $model = new Page('search');
        $model->unsetAttributes();

        if (isset($_GET['Page']))
        {
            $model->attributes = $_GET['Page'];
        }

        $this->render('manage', array(
            "model" => $model
        ));
    }


    public function actionCreate()
    {
        $model = new Page(ActiveRecordModel::SCENARIO_CREATE);
        $form  = new BaseForm('content.PageForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect(array(
                'view',
                'id' => $model->id
            ));
        }

        $this->render('create', array('form' => $form));
    }


    public function actionView($id)
    {
        $model = $this->loadModel($id);

        if (isset($_GET['json']))
        {
            echo CJSON::encode($model);
        }
        else
        {
            $this->render('view', array('model' => $model));
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $form = new BaseForm('content.PageForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect(array(
                'view',
                'id'=> $model->id
            ));
        }
        $this->render('update', array('form' => $form,));
    }


    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        if (!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }


    public function actionGetJsonData($id)
    {
        echo CJSON::encode($this->loadModel($id));
    }
}
