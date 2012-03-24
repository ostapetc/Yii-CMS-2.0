<?php

class MenuAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Create" => "Добавление меню",
            "Update" => "Редактирование меню",
            "Manage" => "Управление меню",
            "Delete" => "Удаление меню",
        );
    }


    public function actionCreate()
    {
        $model = new Menu;

        $form = new BaseForm('content.MenuForm', $model);

        if ($form->submitted() && $model->save())
        {
            $section          = new MenuSection();
            $section->menu_id = $model->id;
            $section->title   = $model->name . '::корень';
            $section->saveNode();

            $this->redirect('/content/MenuAdmin/manage/');
        }

        $this->render('create', array('form' => $form));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $form = new BaseForm('content.MenuForm', $model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect($this->createUrl('manage'));
        }

        $this->render('update', array('form' => $form));
    }


    public function actionManage()
    {
        $model = new Menu(ActiveRecordModel::SCENARIO_SEARCH);
        $model->unsetAttributes();

        if (isset($_GET['Menu']))
        {
            $model->attributes = $_GET['Menu'];
        }

        $this->render('manage', array('model' => $model));
    }


    public function actionDelete($id)
    {
        $model = $this->loadModel($id)->delete();

        $this->redirect($this->createUrl('manage'));
    }

}
