<?php

abstract class BaseController extends CController
{
    public $layout = '//layouts/main';

    public $page_title;

    public $meta_title;

    public $meta_description;

    public $meta_keywords;

    public $crumbs = array();

    public $is_ssl_protected = false;


    public $system_actions = array(
        'captcha'
    );

    abstract public static function actionsTitles();


    public function filters()
    {
        return array(
            array('application.components.filters.LanguageFilter'),
            array('application.components.filters.SiteEnableFilter'),
            array('application.components.filters.HttpsFilter'),
            array('application.components.filters.YXssFilter'),
            array('application.components.filters.MetaTagsFilter + view'),
            array('application.components.filters.StatisticFilter'),
            array('application.components.filters.ThemeFilter'),
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
        $item_name = AuthItem::constructName(Yii::app()->controller->id, $action->id);

        if (in_array($action->id, $this->system_actions))
        {
            return true;
        }

        if (!isset($action_titles[ucfirst($action->id)]))
        {
            //throw new CHttpException('Не найден заголовок для дейсвия ' . ucfirst($action->id));
        }

        if (isset(Yii::app()->params->save_site_actions) && Yii::app()->params->save_site_actions)
        {
            MainModule::saveSiteAction();
        }

        $this->setTitle($action);

        return true;
    }


    public function getModelClass()
    {
        return ucfirst(str_replace('Admin', '', $this->id));
    }


    public function setTitle($action)
    {
        $action_titles = call_user_func(array(
            get_class($action->controller), 'actionsTitles'
        ));

        if (in_array($action->id, $this->system_actions))
        {
            return;
        }

        if (!isset($action_titles[ucfirst($action->id)]))
        {
            throw new CHttpException('Не найден заголовок для дейсвия ' . ucfirst($action->id));
        }

        $this->page_title = $action_titles[ucfirst($action->id)];
    }


    /**
     * @throws CHttpException
     */
    protected function pageNotFound()
    {
        throw new CHttpException(404, t('Страница не найдена!'));
    }


    /**
     * @throws CHttpException
     */
    protected function forbidden($auth_item = null)
    {
        $msg = t('Запрещено!');
        if (YII_DEBUG && $auth_item)
        {
            $msg.= ' AuthItem : ' .$auth_item;
        }
    
        throw new CHttpException(403, $msg);
    }


    public function getRequest()
    {
        return Yii::app()->request;
    }


    public function msg($msg, $type)
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

    public function widget($className,$properties=array(),$captureOutput=false)
    {
        $res = false;

        $widget=$this->createWidget($className,$properties);

        if (isset($widget->cache_id) && $widget->cache_id)
        {
            $res = Yii::app()->cache->get($widget->cache_id);
        }

        if ($res === false)
        {
            ob_start();
            ob_implicit_flush(false);
            $widget->run();
            $res = ob_get_clean();
        }

        if (isset($widget->cache_id) && $widget->cache_id)
        {
            Yii::app()->cache->set($widget->cache_id, $res, 60);
        }

        if($captureOutput)
        {
            return $res;
        }
        else
        {
            echo $res;
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

        $languages = Language::getCachedArray();
        return isset($languages[trim($url, "/")]);
    }
}
