<?

/**
 * TODO: убить интерфес он тут не нужен
 */
abstract class Controller extends CController implements ControllerInterface
{
    const MSG_SUCCESS = 'success';
    const MSG_DANGER  = 'danger';
    const MSG_ERROR   = 'error';
    const MSG_INFO    = 'info';

    public $layout = '//layouts/main';

    public $page_title;

    public $meta_title;

    public $meta_description;

    public $meta_keywords;

    public $crumbs = array();

    public $is_ssl_protected = false;


    public function filters()
    {
        return array(
            array('application.components.filters.LanguageFilter'),
            array('application.components.filters.SiteEnableFilter'),
            array('application.components.filters.HttpsFilter'),
            array('application.components.filters.XssFilter'),
            array('application.components.filters.MetaTagsFilter + view'),
            array('application.components.filters.StatisticFilter'),
            array('application.components.filters.ThemeFilter'),
            array('application.components.filters.ReturnUrlFilter'),
        );
    }


    public function actions()
    {
        return array(
            'captcha' => array(
                'class'     => 'CCaptchaAction',
                'testLimit' => 6,
                'minLength' => 4,
                'maxLength' => 5,
                'offset'    => 1,
                'width'     => 68,
                'height'    => 30,
                'backColor' => 0xBBBBBB,
                'foreColor' => 0x222222
            )
        );
    }


    public function beforeAction($action)
    {
        $action_name = lcfirst($action->id);

        $this->setTitle($action_name);

        return true;
    }


    public function afterAction($action)
    {
        if (isset(Yii::app()->params->save_site_actions) && Yii::app()->params->save_site_actions)
        {
            MainModule::saveSiteAction();
        }
    }


    public function getModelClass()
    {
        return ucfirst(str_replace('Admin', '', $this->id));
    }


    public function setTitle($action_name)
    {
        $action_titles = $this->actionsTitles();

        if (!isset($action_titles[$action_name]))
        {
            throw new CHttpException('Не найден заголовок для дейсвия ' . $action_name);
        }

        $this->page_title = $action_titles[$action_name];
    }


    protected function pageNotFound()
    {
        throw new CHttpException(404, t('Страница не найдена!'));
    }


    protected function forbidden($auth_item = null)
    {
        $msg = t('Запрещено!');
        if (YII_DEBUG && $auth_item)
        {
            $msg.= ' AuthItem : ' .$auth_item;
        }
    
        throw new CHttpException(403, $msg);
    }


    protected function badRequest()
    {
        throw new CHttpException(400, t('Неверный запрос!'));
    }


    public function getRequest()
    {
        return Yii::app()->request;
    }


    public static function msg($msg, $type)
    {
        return CHtml::tag('div', array('class'=>"alert alert-{$type}"), $msg);
    }


    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Возвращает модель по атрибуту и удовлетворяющую скоупам,
     * или выбрасывает 404
     *
     * @param string     $class  имя класса модели
     * @param int|string $value  значение атрибута
     * @param array      $scopes массив скоупов
     * @param string     $attribute
     *
     * @return CActiveRecord
     */
    public function loadModel($value, $scopes = array(), $attribute = null)
    {
        $model = CActiveRecord::model($this->getModelClass());

        foreach ($scopes as $scope)
        {
            $model->$scope();
        }

        if ($attribute === null)
        {
            $model = $model->findByPk($value);
        }
        else
        {
            $model = $model->findByAttributes(array(
                $attribute => $value
            ));
        }

        if ($model === null)
        {
            $this->pageNotFound();
        }

        return $model;
    }


    public function isRootUrl($url = null)
    {
        if (!$url)
        {
            $url = $_SERVER["REQUEST_URI"];
        }

        $languages = Language::getList();
        return isset($languages[trim($url, "/")]);
    }

    /**
     * add profile information to std widget call
     *
     * @param string $className
     * @param array $properties
     * @param bool $captureOutput
     * @return mixed
     */
    public function widget($className,$properties=array(),$captureOutput=false)
    {
        $profile_id = 'Widget::'.$className;

        //profile widget
        Yii::beginProfile($profile_id);
        $res = parent::widget($className,$properties,true);
        Yii::endProfile($profile_id);

        if ($captureOutput)
        {
            return $res;
        }
        else
        {
            echo $res;
        }
    }


}
