<?php

abstract class BaseController extends CController
{
    public $layout = '//layouts/main';

    public $page_title;

    public $meta_title;

    public $meta_description;

    public $meta_keywords;

    public $crumbs = array();

    public $isSslProtected = false;

    abstract public static function actionsTitles();

    public function init()
    {
        parent::init();
        $this->_initLanguage();
    }


    private function _initLanguage()
    {
        if (isset($_GET['language']))
        {
            Yii::app()->setLanguage($_GET['language']);
            Yii::app()->session['language'] = $_GET['language'];
        }

        if (
            !isset(Yii::app()->session['language']) || Yii::app()->session['language'] != Yii::app()->language
        )
        {
            Yii::app()->session['language'] = Yii::app()->language;
        }
    }


    public function filters()
    {
        Yii::import('application.components.filters.*');
        return array('https', 'metaTags');
    }

    public function filterHttps($filterChain)
    {
        $filter = new HttpsFilter();
        $filter->filter($filterChain);
    }

    public function filterMetaTags($filterChain)
    {
        $filter = new MetaTagsFilter();
        $filter->filter($filterChain);
    }

    public function beforeAction($action)
    {

        $item_name = AuthItem::constructName(Yii::app()->controller->id, $action->id);
        if (!RbacModule::isAllow($item_name))
        {   echo $item_name;
            $this->forbidden();
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

        if (!isset($action_titles[ucfirst($action->id)]))
        {
            throw new CHttpException('Не найден заголовок для дейсвия ' . ucfirst($action->id));
        }

        $title = $action_titles[ucfirst($action->id)];

        $this->page_title = $title;
    }


    /**
     * @throws CHttpException
     */
    protected function pageNotFound()
    {
        throw new CHttpException(404, 'Страница не найдена!');
    }


    /**
     * @throws CHttpException
     */
    protected function forbidden()
    {
        throw new CHttpException(403, 'Запрещено!');
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
}
