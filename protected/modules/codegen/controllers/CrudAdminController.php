<?php

class CrudAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create'   => 'Создание CRUD-а',
            'GetFiles' => 'Получить файлы'
        );
    }


    public function actionCreate()
    {
        $model = new Crud();
        $form  = new Form('codegen.CrudForm', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->validate())
        {
            die;
        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionGetFiles($model, $return = false)
    {
        $this->layout = false;

        $paths = array(111,222,333,444,555);

        if ($return)
        {

        }
        else
        {
            $this->render('getFiles', array(
                'paths' => $paths
            ));
        }
    }
}
