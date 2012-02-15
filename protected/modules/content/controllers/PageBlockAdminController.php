<?php

class PageBlockAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "View"   => t("Просмотр контентного блока"),
            "Create" => t("Добавление контентного блока"),
            "Update" => t("Редактирование контентного блока"),
            "Delete" => t("Удаление контентного блока"),
            "Manage" => t("Управление контентными блоками")
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
        $model = new PageBlock;

        $form = new BaseForm('content.PageBlockForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect(array(
                'view',
                'id' => $model->id
            ));
        }

        $this->render('create', array(
            'form' => $form,
        ));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $form = new BaseForm('content.PageBlockForm', $model);
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


    public function actionManage()
    {
        $model = new PageBlock('search');
        $model->unsetAttributes();

        if (isset($_GET['PageBlock']))
        {
            $model->attributes = $_GET['PageBlock'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }

}
