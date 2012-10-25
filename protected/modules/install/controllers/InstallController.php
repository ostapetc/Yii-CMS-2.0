<?
class InstallController extends ClientController
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
                $this->redirect('/install.php?r=/install/install/step2');
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

            //$step1->deleteDisableModules();

            //migrate
            Yii::app()->getModule('users');

            foreach (Yii::app()->getModules() as $id => $data)
            {
                Yii::app()->getModule($id);
                if (is_dir(Yii::getPathOfAlias($id.'.migrations')))
                {
                    Yii::app()->executor->migrate('up --module='.$id);
                }
            }

            //create admin user
            $user = new User;
            list($user->name) = explode('@', $model->admin_email);
            $user->email = $model->admin_email;
            $user->password = UserIdentity::crypt($model->admin_pass);
            $user->status = User::STATUS_ACTIVE;
            $user->save(false);

            //set admin
            $auth = Yii::app()->authManager;

            $auth->clearAll();
            $auth->createRole('Admin');
            $auth->assign('Admin', $user->id);


            //commands collect
            Yii::app()->executor->addCommandsFromModules(Yii::app()->getModules());

            //run install method
            foreach (Yii::app()->getModules() as $id => $conf)
            {
                @mkdir(Yii::getPathOfAlias('webroot.upload.' . $id), 0755, true);
                Yii::app()->getModule($id)->install();
            }

            $model->saveInSession();
            //install base modules
            $this->redirect('/install.php?r=/install/install/step3');
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
        $this->redirect('/install.php?r=/install/install/end');
    }

    public function actionEnd()
    {
        $this->redirect('/index.php');
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
