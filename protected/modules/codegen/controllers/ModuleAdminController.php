<?php

class ModuleAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create'   => 'Создание модуля',
            'GetFiles' => 'Показать файлы модуля'
        );
    }


    public function actionCreate()
    {
        $model = new Module();
        $form  = new Form('codegen.ModuleForm', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->validate())
        {
            $files = $this->actionGetFiles($model->id, true);

            foreach ($files as $file)
            {
                $path_info = pathinfo($file);

                if (isset($path_info['extension']))
                {
                    mkdir($path_info['dirname'], 0777, true);
                    file_put_contents($file, $this->getCode($model));
                    chmod($file, 0777);
                }
                else
                {
                    if (!is_dir($file))
                    {
                        mkdir($file, 0777, true);
                        chmod($file, 0777);
                    }
                }
            }

            Yii::app()->user->setFlash('success', 'Модуль создан!');
            $this->redirect($_SERVER['REQUEST_URI']);
        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function getCode(CFormModel $model)
    {
        $params = $model->attributes;
        $code = $this->renderPartial('application.modules.codegen.views.templates.module.Module', $params, true);
        return $code;
    }


    public function actionGetFiles($id, $return = false)
    {
        $this->layout = false;

        $id = lcfirst($id);

        $paths = array();
        $dir   =  MODULES_PATH . $id;
        $files = glob(Yii::getPathOfAlias('codegen.views.templates.module') . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . '*');

        foreach ($files as $file)
        {
            $base_name = pathinfo($file, PATHINFO_BASENAME);

            if ($base_name == '_')
            {
                $file = str_replace($base_name, null, $file);
            }

            $file = rtrim($file, DIRECTORY_SEPARATOR);

            if ($file == 'Module.php')
            {
                $file = ucfirst($id) . $file;
            }

            $paths[] = str_replace('codegen' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'module', $id, $file);
        }

        if ($return)
        {
            return $paths;
        }
        else
        {
            $paths = array_map(function($path) {
                return str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);
            }, $paths);

            $this->render('getFiles', array(
                'paths' => $paths
            ));
        }
    }
}
























