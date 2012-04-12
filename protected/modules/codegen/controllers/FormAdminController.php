<?php

class FormAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Создание формы'
        );
    }


    public function actionCreate()
    {
        $model = new NewForm();
        $form  = new Form('codegen.NewForm', $model);

        if ($form->submitted() && $model->validate())
        {
            self::generateAndSaveForm($model->model);
            Yii::app()->user->setFlash(Controller::MSG_SUCCESS, 'Форма создана!');
            $this->redirect($_SERVER['REQUEST_URI']);
        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public static function getCode($model_class)
    {
        $model  = ActiveRecord::model($model_class);
        $meta   = $model->meta();
        $params = array(
            'class'  => $model_class,
            'upload' => (bool) $model->uploadFiles()
        );

        $elements = array();
        foreach ($meta as $attr => $data)
        {
            if (in_array($attr, array('id', 'date_create', 'date_update')))
            {
                continue;
            }

            if (in_array($attr, array('file', 'image', 'photo', 'icon')))
            {
                $elements[$attr] = array('type' => 'file');
            }
            else if (substr($attr, 0, 3) == 'is_')
            {
                $elements[$attr] = array('type' => 'checkbox');
            }
            else if (preg_match('|varchar\(([0-9]+)\)|', $data['Type'], $length))
            {
                $length = $length[1];
                if ($length <= 55)
                {
                    $elements[$attr] = array('type' => 'text');
                }
                else
                {
                    $elements[$attr] = array('type' => 'textarea');
                }
            }
            else if (in_array($data['Type'], array('date', 'datetime')))
            {
                $elements[$attr] = array('type' => 'date');
            }
            else if (preg_match('|enum\(.*?\)|', $data['Type']))
            {
                $elements[$attr] = array(
                    'type'  => 'dropdownlist',
                    'items' => $model_class . '::$' . $attr .'_oprions',
                    'empty' => 'не выбрано'
                );
            }
        }

        $params['elements'] = $elements;

        return Yii::app()->controller->renderPartial('application.modules.codegen.views.templates.crud.forms.Form', $params, true);
    }


    public static function generateAndSaveForm($model_class)
    {
        $code = self::getCode($model_class);

        $form_path = array_shift(glob(MODULES_PATH . '*' . DS . 'models' . DS . $model_class . '.php'));
        $form_path = str_replace(
            array(DS . 'models', $model_class),
            array(DS . 'forms', str_replace('Model', 'Form', $model_class)),
            $form_path
        );

        file_put_contents($form_path, $code);
    }
}
