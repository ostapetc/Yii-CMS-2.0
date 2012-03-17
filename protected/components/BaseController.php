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



    /**
     * Обертка для Yii::t, выполняет перевод по словарям текущего модуля.
     * Так же перевод осуществляется по словорям с префиксом {modelId},
     * где modelId - приведенная к нижнему регистру база имени контроллера
     *
     * Например: для контроллера ProductInfoAdminController, находящегося в модуле ProductsModule
     * перевод будет осуществляться по словарю ProductsModule.product_info_{первый параметр метода}
     *
     * @param string $dictionary словарь
     * @param string $alias      фраза для перевода
     * @param array  $params
     * @param string $language
     *
     * @return string переводa
     */
    public function t($dictionary, $alias, $params = array(), $source = null, $language = null)
    {
        $file_prefix = StringHelper::camelCaseToUnderscore($this->getModelClass());
        return Yii::t(get_class($this->module).'.'.$file_prefix.'_'.$dictionary, $alias, $params, $source, $language);
    }
}
