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
        $requirements = array(
            'PHP' => array(
                'is_support'      => version_compare(phpversion(), '5.3', '>'),
                'version'         => phpversion(),
                'minimal_version' => '5.3',
            ),
            'Reflection' => array(
                'is_support'      => class_exists('Reflection', false),
            ),
            'SPL' => array(
                'is_support'      => extension_loaded("SPL"),
            ),
            'DOMDocument' => array(
                'is_support'      => class_exists("DOMDocument", false),
            ),
            'mcrypt' => array(
                'is_support'      => extension_loaded("mcrypt"),
            ),
            'soap' => array(
                'is_support'      => extension_loaded("soap"),
            ),
        );
        $this->render('index', array('support' => $requirements));
    }

    public function actionStep1()
    {
        $model = new Step1();
        $form = new Form('install.Step1', $model);

        $this->performAjaxValidation($model);
        if ($form->submitted() && $model->validate())
        {
            //create db
            $db_create_status = InstallHelper::createDb($model);
            if ($db_create_status === true)
            {
                //create configs
                InstallHelper::parseConfig('development', $model->getDbPatterns());
                InstallHelper::parseConfig('production', array());
            }
            else if (is_string($db_create_status))
            {
                MsgStream::getInstance()->enqueue($db_create_status, 'error');
            }

            if (MsgStream::getInstance()->count() == 0)
            {
                Yii::app()->user->setState('install_step1', $model->attributes);
                $this->redirect('step2');
            }
        }


        $this->render('step1', array('form' => $form));
    }

    public function actionStep2()
    {
        $step1 = new Step1();
        $step1->attributes = Yii::app()->user->getState('install_step1');

        $model = new Step2();
        $form = new Form('install.Step2', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->validate())
        {
            InstallHelper::parseConfig('main', $model->getMainConfigPatterns());

            //install modules
            Yii::app()->setModules($model->modules);
            foreach ($model->modules as $module)
            {
                dump(Yii::app()->getModule($module)->install());
                Yii::app()->executor->addCommands($module.'.commands');
            }
            Yii::app()->executor->migrate('up');
            //install base modules
            Yii::app()->user->setState('install_step2', $model->attributes);
            //$this->redirect('step3');
        }

        $this->render('step2', array('form' => $form));
    }

    public function actionStep3()
    {
        $step1 = new Step1();
        $step1->attributes = Yii::app()->user->getState('install_step1');

        $step2 = new Step2();
        $step2->attributes = Yii::app()->user->getState('install_step2');


        //done!
        //replace config in index.php
        //redirect - no end
        //install - uninstall
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


