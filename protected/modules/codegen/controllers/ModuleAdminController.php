<?php

class ModuleAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create'    => 'Создание модуля',
            'ShowFiles' => 'Показать файлы модуля'
        );
    }


    public function actionCreate()
    {
        $model = new Module();
        $form  = new Form('codegen.ModuleForm', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->validate())
        {

        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionShowFiles($id)
    {
        $this->layout = false;

        $paths = array();
        $dir   =  MODULES_PATH . DIRECTORY_SEPARATOR . $id;
        $files = scandir(Yii::getPathOfAlias('codegen.views.templates.module'));

        foreach ($files as $file)
        {
            if ($file[0] == '.')
            {
                continue;
            }

            $paths[] = $dir . $file;
        }

        $this->render('showFiles', array(
            'paths' => $paths
        ));
    }
}
























