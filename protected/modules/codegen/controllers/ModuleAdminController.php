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
            $module_dir = MODULES_PATH . lcfirst($model->id);
            if (!is_dir($module_dir))
            {
                mkdir($module_dir);
                chmod($module_dir, 0777);
            }

            $files = $this->actionGetFiles($model->id, true);
            foreach ($files as $file)
            {
                $path_info = pathinfo($file);

                if (isset($path_info['extension']))
                {
                    file_put_contents($file, $this->getCode($model));
                    chmod($file, 0777);
                }
                else
                {
                    if (!is_dir($file))
                    {
                        mkdir($file);
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
        $files = scandir(Yii::getPathOfAlias('application.modules.codegen.views.templates.module'));

        foreach ($files as $file)
        {
            if ($file[0] == '.')
            {
                continue;
            }

            if ($file == 'Module.php')
            {
                $file = ucfirst($id) . $file;
            }

            $paths[] = $dir . DIRECTORY_SEPARATOR . $file;
        }

        if ($return)
        {
            return $paths;
        }
        else
        {
            $this->render('getFiles', array(
                'paths' => $paths
            ));
        }
    }
}
























