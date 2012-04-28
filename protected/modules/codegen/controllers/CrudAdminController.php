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

            FormAdminController::generateAndSaveForm($model->class);

            $params = $model->attributes;
            $params['module'] = AppManager::getModelModule($model->class);

            $controllers_path  = 'application.modules.codegen.views.templates.crud.controllers';
            $controllers_files = glob(Yii::getPathOfAlias($controllers_path) . DS . '*');
            foreach ($controllers_files as $controller_file)
            {
                $file_name = pathinfo($controller_file, PATHINFO_FILENAME);

                $code = $this->renderPartial($controllers_path . '.' . $file_name, $params, true);

                $file_name = $model->class . $file_name . '.php';

                $dir = MODULES_PATH . $params['module'] . DS . 'controllers' . DS;
                if (!is_dir($dir))
                {
                    mkdir($dir, 0777, true);
                    chmod($dir, 0777);
                }

                $file_path = $dir . $file_name;

                file_put_contents($file_path, $code);
                chmod($file_path, 0777);
            }

            $views_path  = 'application.modules.codegen.views.templates.crud.views';
            $views_files = glob(Yii::getPathOfAlias($views_path) . DS . '*' . DS . '*');

            foreach($views_files as $view_file)
            {
                $view_file      = str_replace(Yii::getPathOfAlias($views_path) , '', $view_file);
                $file_name      = pathinfo($view_file, PATHINFO_BASENAME);
                $file_code      = $this->renderPartial($views_path . str_replace(array(DS, '.php') , array('.', ''), $view_file), $params, true);
                $view_file_path = MODULES_PATH . $params['module'] . DS . 'views' . $view_file;
                $view_file_dir  = pathinfo($view_file_path, PATHINFO_DIRNAME);
                $child_dir      = pathinfo($view_file_dir, PATHINFO_FILENAME);

                if ($child_dir == 'client')
                {
                    $view_file_dir = str_replace('client', lcfirst($model->class), $view_file_dir);
                }
                else if ($child_dir == 'admin')
                {
                    $view_file_dir = str_replace('admin', lcfirst($model->class) . 'Admin', $view_file_dir);
                }

                if (!is_dir($view_file_dir))
                {
                    mkdir($view_file_dir, 0777, true);
                    chmod($view_file_dir, 0777);
                }

                $file_path = $view_file_dir . DS . $file_name;

                file_put_contents($file_path, $file_code);
                chmod($file_path, 0777);
            }

            $msg = "Добавьте  в метод adminMenu()  в файле " . ucfirst($params['module']) . "Module.php<br/>
                   'Управление {$params['instrumental']}'    => Yii::app()->createUrl('/{$params['module']}/" . lcfirst($params['class']) . "Admin/manage'), <br/>
                   'Создать {$params['accusative']}' => Yii::app()->createUrl(''/{$params['module']}/" . lcfirst($params['class']) . "Admin/create'),";

            Yii::app()->user->setFlash(Controller::MSG_SUCCESS, 'CRUD создан!');
            Yii::app()->user->setFlash(Controller::MSG_INFO, $msg);
            die;
            $this->redirect($_SERVER['REQUEST_URI']);
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
