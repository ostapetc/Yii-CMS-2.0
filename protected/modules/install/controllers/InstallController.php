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
                $model->saveInSession();
                $this->redirect('/install.php/install/install/step2');
            }
            else if (is_string($db_create_status))
            {
                Yii::app()->user->setFlash('error', $db_create_status);
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
            Yii::app()->user->setState('install_configs', $configs);

            $step1 = Step1::loadFromSession();

            Yii::app()->setComponent('db', $step1->createDbConnection());
            //install modules
            Yii::app()->setModules($model->modules);

            //base db init
            $step1->dbInit(Yii::app()->getModules());

            //migrate
            foreach (Yii::app()->getModules() as $id => $data)
            {
                if (is_dir(Yii::getPathOfAlias($id.'.migrations')))
                {
                    Yii::app()->executor->migrate('up --module='.$id);
                }
            }

            //commands collect
            Yii::app()->executor->addCommandsFromModules(Yii::app()->getModules());

            //run install method
            foreach (Yii::app()->getModules() as $module => $conf)
            {
                Yii::app()->getModule($module)->install();
            }

            //$step1->deleteDisableModules();
            $model->saveInSession();
            //install base modules
            $this->redirect('/install.php/install/install/step3');
        }

        $this->render('step2', array('form' => $form));
    }

    public function actionStep3()
    {
        $configs = Yii::app()->user->getState('install_configs');
        foreach ($configs as $file => $data)
        {
            InstallHelper::parseConfig($file, $data);
        }

//        @unlink(Yii::getPathOfAlias('webroot.insall').'.php');
//        @unlink(Yii::getPathOfAlias('application.config.install').'.php');
        $this->redirect('end');
    }

    public function actionEnd()
    {
        $this->redirect('/');
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
