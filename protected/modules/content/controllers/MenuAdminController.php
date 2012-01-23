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

        $this->performAjaxValidation($model);
        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->validate())
            {
                $model->save(false);
                $this->redirect(array('/content/menuLinkAdmin/index', 'menu_id'=> $model->id));
            }
        }

        $this->render('create', array('form' => $form));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $form = new BaseForm('content.MenuForm', $model);

        $this->performAjaxValidation($model);
        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect($this->createUrl('manage'));
            }
        }

        $this->render('update', array('form' => $form));
    }


    public function actionManage()
    {
        $model = new Menu();

        $this->render('manage', array('model' => $model));
    }


    public function actionDelete($id)
    {
        $model = $this->loadModel($id)->delete();

        $this->redirect($this->createUrl('manage'));
    }

}
