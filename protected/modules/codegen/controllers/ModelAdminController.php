<?php

class ModelAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create'      => 'Генерация модели',
            'CodePreview' => 'Превью кода'
        );
    }


    public function actionCreate()
    {
        $model = new Model();
        $form  = new Form('Codegen.ModelForm', $model);

        $this->performAjaxValidation($model);

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionCodePreview()
    {
        if (isset($_POST['Model']))
        {
            $model = new Model();
            $model->attributes = $_POST['Model'];
            if ($model->validate())
            {
                echo "good";
            }
            else
            {
                echo "Заполните корректно данные!";
            }
        }
    }
}
