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
        $code = $this->getFormCode('User');


        die;
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


    public function getFormCode($model_class)
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
                    'items' => $model_class . '::$' . $attr .'_options',
                    'empty' => 'не выбрано'
                );
            }
        }

        $params['elements'] = $elements;

        $code = $this->renderPartial('codegen.views.templates.crud.forms.Form', $params, true);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/form.php', $code);
    }


    public function actionGetFiles($model, $return = false)
    {
        $this->layout = false;

        $paths = array();

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
