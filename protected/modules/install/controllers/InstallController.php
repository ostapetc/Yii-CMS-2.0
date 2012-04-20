<?

class InstallController extends Controller
{

    public function filters()
    {
        return array();
    }

    public function beforeAction()
    {
        return true;
    }

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
        $support['PHP'] = array(
            'is_support'      => version_compare(phpversion(), '5.3', '>'),
            'version'         => phpversion(),
            'minimal_version' => '5.3',
        );
        $this->render('index', array('support' => $support));
    }

    public function actionStep1()
    {
        $model = new Step1();
        $form = new Form('install.Step1', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->validate())
        {
            $this->parseFile('application.config.development', $model->getDbPatterns());
            $this->parseFile('application.config.production', array());
            $this->redirect('step2');
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
            $this->parseFile('application.config.main', $model->getMainConfigPatterns());

            //set configs
            //install base modules

            //$this->redirect('step3');
        }

        $this->render('step2', array('form' => $form));
    }

    public function actionStep3()
    {
        //done!
        //replace config in index.php
        //redirect - no end
        //install - uninstall
    }

    private function parseFile($alias, $data)
    {
        $file = Yii::getPathOfAlias($alias);

        $content = strtr(file_get_contents($file.'.tpl.php'), $data);
        rename ($file.'.tpl.php', $file.'.php');
        file_put_contents($file.'.php', $content);
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
