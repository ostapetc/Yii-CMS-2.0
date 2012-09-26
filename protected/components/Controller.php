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
            array('application.components.filters.RbacFilter'),
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


    public function subMenuItems()
    {
        return array();
    }


    public function beforeAction($action)
    {
        $this->setTitle(lcfirst($action->id));
        return true;
    }


    public function afterAction($action)
    {
        if (isset(Yii::app()->params->save_site_actions) && Yii::app()->params->save_site_actions)
        {
            MainModule::saveSiteAction();
        }

        if (!isset($_GET['modal']))
        {
            //не работает
            $this->request->prev_url = $this->request->url;
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
            throw new CException('Не найден заголовок для дейсвия ' . $action_name);
        }

        $this->page_title = $action_titles[$action_name];
    }


    public function pageNotFound()
    {
        throw new CHttpException(404, t('Страница не найдена!'));
    }


    public function forbidden($msg = null)
    {
        if (!$msg)
        {
            $msg = t('Запрещено!');
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
        return CHtml::tag('div', array('class'=> "alert alert-{$type}"), $msg);
    }


    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function setMetaTags($modelOrConfig)
    {
        if ($modelOrConfig instanceof CActiveRecord)
        {
            $meta_tag = MetaTag::model()->findByAttributes(array(
                'model_id'  => get_class($modelOrConfig),
                'object_id' => $modelOrConfig->getPrimaryKey()
            ));
            if ($meta_tag)
            {
                $meta_tag = array(
                    'title'       => $meta_tag->title,
                    'description' => $meta_tag->description,
                    'keywords'    => $meta_tag->keywords
                );
            }
        }
        else
        {
            $meta_tag = $modelOrConfig;
        }
        foreach ((array)$meta_tag as $key => $val)
        {
            if (is_string($val))
            {
                Yii::app()->clientScript->registerMetaTag($val, $key);
            }
        }
    }


    /**
     * Возвращает модель по атрибуту и удовлетворяющую скоупам,
     * или выбрасывает 404
     *
     * @param string           $class        имя класса модели
     * @param int|string|array $valueOrArray значение атрибута
     * @param array            $scopes       массив скоупов
     *
     * @return CActiveRecord
     */
    public function loadModel($valueOrArray, $scopes = array())
    {
        $model = ActiveRecord::model($this->getModelClass());

        foreach ($scopes as $scope)
        {
            $model->$scope();
        }

        if (is_array($valueOrArray))
        {
            return $model->throw404IfNull()->findByAttributes($valueOrArray);
        }
        else
        {
            return $model->throw404IfNull()->findByPk($valueOrArray);
        }
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
     * @param array  $properties
     * @param bool   $captureOutput
     *
     * @return mixed
     */
    public function widget($className, $properties = array(), $captureOutput = false)
    {
        $profile_id = 'Widget::' . $className;

        //profile widget
//        Yii::beginProfile($profile_id);
        $res = parent::widget($className, $properties, $captureOutput);
//        Yii::endProfile($profile_id);
        return $res;
    }


    public function render($view, $data = null, $return = false)
    {
        if (Yii::app()->request->getParam('modal'))
        {
            $this->layout = false;
        }
        if (Yii::app()->request->getParam('iframe'))
        {
            $this->layout = '//layouts/iframe';
        }
        return parent::render($view, $data, $return);
    }
}
