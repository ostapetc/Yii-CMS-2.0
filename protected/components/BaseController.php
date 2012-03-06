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


    public function filters()
    {
        return array(
            array('application.components.filters.HttpsFilter'),
            array('application.components.filters.YXssFilter'),
            array('application.components.filters.LanguageFilter'),
            array('application.components.filters.MetaTagsFilter + view'),
            array('application.components.filters.StatisticFilter'),
        );
    }

    public function beforeAction($action)
    {
        //check access
        $item_name = AuthItem::constructName(Yii::app()->controller->id, $action->id);
        if (!Yii::app()->user->checkAccess($item_name))
        {
            $this->forbidden();
        }
        //set default title
        $action_titles = $this->actionsTitles();

        if (!isset($action_titles[ucfirst($action->id)]))
        {
            throw new CHttpException('Не найден заголовок для дейсвия ' . ucfirst($action->id));
        }

        $this->page_title = $action_titles[ucfirst($action->id)];

        return true;
    }


    public function getModelClass()
    {
        return ucfirst(str_replace('Admin', '', $this->id));
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
    protected function forbidden()
    {
        throw new CHttpException(403, t('Запрещено!'));
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
