<?php

abstract class BaseController extends CController
{
    public $layout = '//layouts/main';

    public $page_title;

    public $meta_title;

    public $meta_description;

    public $meta_keywords;

    public $crumbs = array();

    abstract public static function actionsTitles();

    public function init()
    {
        parent::init();
        $this->_initLanguage();
        if (YII_DEBUG)
        {
            Yii::app()->clientScript->registerScriptFile('/js/plugins/debug.js');
        }
    }

    private function _initLanguage()
    {
        if (isset($_GET['lang']))
        {
            Yii::app()->setLanguage($_GET['lang']);
            Yii::app()->session['language'] = $_GET['lang'];
        }

        if (!isset(Yii::app()->session['language']) || Yii::app()->session['language'] != Yii::app()->language)
        {
            Yii::app()->session['language'] = Yii::app()->language;
        }
    }

    public function beforeAction($action)
    {
        $item_name = AuthItem::constructName(Yii::app()->controller->id, $action->id);

        if (!RbacModule::isAllow($item_name))
        {
            $this->forbidden();
        }

        if (isset(Yii::app()->params->save_site_actions) && Yii::app()->params->save_site_actions)
        {
            MainModule::saveSiteAction();
        }

        $this->setTitle($action);
        $this->_setMetaTags($action);

        return true;
    }


    private function _setMetaTags($action)
    {
        if ($action->id != 'view' || $this instanceof AdminController)
        {
            return false;
        }

        $id = $this->request->getParam("id");
        if ($id)
        {
            $class = $this->getModelClass();

            $meta_tag = MetaTag::model()->findByAttributes(array(
                'model_id'  => $class,
                'object_id' => $id
            ));

            if ($meta_tag)
            {
                $this->meta_title       = $meta_tag->title;
                $this->meta_keywords    = $meta_tag->keywords;
                $this->meta_description = $meta_tag->description;
            }
        }
    }

    private function getModelClass()
    {
        return ucfirst(str_replace('Admin', '', $this->id));
    }

    public function setTitle($action)
    {
        $action_titles = call_user_func(array(
            get_class($action->controller),
            'actionsTitles'
        ));

        if (!isset($action_titles[ucfirst($action->id)]))
        {
            throw new CHttpException('Не найден заголовок для дейсвия '.ucfirst($action->id));
        }

        $title = $action_titles[ucfirst($action->id)];

        $this->page_title = $title;
    }


    public function url($route, $params = array(), $ampersand = '&')
    {
        $url = $this->createUrl($route, $params, $ampersand);

        return $url;
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
        return "<div class='message {$type}' style='display: block;'>
                    <p>{$msg}</p>
                </div>";
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
