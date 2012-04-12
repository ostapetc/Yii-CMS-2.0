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

        if ($form->submitted() && $model->validate())
        {
            Yii::import('application.modules.codegen.controllers.FormAdminController');

            FormAdminController::generateAndSaveForm($model->model);

            $params = array(
                'class'  => $model->model,
                'module' => AppManager::getModelModule($model->model)
            );

            $controllers_path  = 'application.modules.codegen.views.templates.crud.controllers';
            $controllers_files = glob(Yii::getPathOfAlias($controllers_path) . DS . '*');
            foreach ($controllers_files as $controller_file)
            {
                $file_name = pathinfo($controller_file, PATHINFO_FILENAME);

                $code = $this->renderPartial($controllers_path . '.' . $file_name, $params, true);

                $file_name = $model->model . $file_name . '.php';

                $file_path = MODULES_PATH . $params['module'] . DS . 'controllers' . DS . $file_name;
                file_put_contents($file_path, $code);
                chmod($file_path, 0777);
            }

            $views_path  = 'application.modules.codegen.views.templates.crud.views';
            $views_files = glob(Yii::getPathOfAlias($views_path) . DS . '*' . DS . '*');
            foreach($views_files as $view_file)
            {
                $view_file = str_replace(Yii::getPathOfAlias($views_path) , '', $view_file);

                $code = $this->renderPartial($views_path . str_replace(array(DS, '.php') , array('.', ''), $view_file), $params, true);

                $view_file_path = MODULES_PATH . $params['module'] . DS . 'views' . $view_file;
                $view_file_dir  = pathinfo($view_file_path, PATHINFO_DIRNAME);

                $child_dir = pathinfo($view_file_dir, PATHINFO_FILENAME);
                if ($child_dir == 'client')
                {
                    $view_file_dir = str_replace('client', lcfirst($model->model), $view_file_dir);
                }
                else if ($child_dir == 'admin')
                {
                    $view_file_dir = str_replace('admin', lcfirst($model->model) . 'Admin', $view_file_dir);
                }

                if (!is_dir($view_file_dir))
                {
                    mkdir($view_file_dir, 0777, true);
                    chmod($view_file_dir, 0777);
                }

                p($view_file_dir);
            }

            //p($views_files);


            die;
        }

        $this->render('create', array(
            'form' => $form
        ));
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
