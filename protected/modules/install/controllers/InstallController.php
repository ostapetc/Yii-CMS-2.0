<?
class InstallController extends Controller
{

    public function filters()
    {
        return array(
            array('application.components.filters.ReturnUrlFilter'),
        );
    }

    public function beforeAction($action) {return true;}
    public function afterAction($action) {}

    public $layout = 'install';


    public static function actionsTitles()
    {
        return array(
            "Index"         => "Установка",
            "Step1"         => "Шаг 1/3",
            "Step2"         => "Шаг 2/3",
            "Step3"         => "Шаг 3/3",
            "Error"         => "Ошибка"
        );
    }

    public function actionIndex()
    {
        $this->render('index', array('model' => new Step0()));
    }

    public function actionStep1()
    {
        $model = new Step1();
        $form = new Form('install.Step1', $model);

        $this->performAjaxValidation($model);
        if ($form->submitted() && $model->validate())
        {
            //create db
            $db_create_status = $model->createDb();
            if ($db_create_status === true)
            {
                Yii::app()->user->setState('install_configs', $model->getConfigs());
            }
            else if (is_string($db_create_status))
            {
                MsgStream::getInstance()->enqueue($db_create_status, 'error');
            }

            if (MsgStream::getInstance()->count() == 0)
            {
                $model->saveInSession();
                $this->redirect('step2');
            }
        }

        $this->render('step1', array('form' => $form));
    }

    public function actionStep2()
    {

        $model = new Step2();
        $form = new Form('install.Step2', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->validate())
        {
            $configs = CMap::mergeArray(Yii::app()->user->getState('install_configs'), $model->getConfigs());
            Yii::app()->user->setState('install_configs',$configs);

            $step1 = new Step1();
            $step1->loadFromSession();

            Yii::app()->setComponent('db', $step1->createDbConnection());
            //install modules
            Yii::app()->setModules($model->modules);
            Yii::app()->executor->migrate('up --module=install');
            foreach ($model->modules as $module)
            {
                if (is_dir(Yii::getPathOfAlias($module.'.migrations')))
                {
                    Yii::app()->executor->migrate('up --module=main');
                }

                Yii::app()->executor->addCommands($module.'.commands');
            }

            foreach (Yii::app()->getModules() as $module => $conf)
            {
                $module =Yii::app()->getModule($module);
                if (method_exists($module, 'install'))
                {
                    $module->install();
                }
            }

            $model->saveInSession();
            //install base modules
            $this->redirect('step3');
        }

        $this->render('step2', array('form' => $form));
    }

    public function actionStep3()
    {
        $configs = Yii::app()->user->getState('install_configs');
        foreach ($configs as $file => $data)
        {
//            InstallHelper::parseConfig($file, $data);
        }
        //done!
        //replace config in index.php
        $this->redirect('end');
    }

    public function actionEnd()
    {
        $this->render('end');
    }


    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                echo $error['message'];
            }
            else
            {
                $this->render('error', $error);
            }
        }
    }
}


