<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 30.05.12
 * Time: 20:43
 * To change this template use File | Settings | File Templates.
 */

Yii::import('zii.widgets.CPortlet');

class CommentsPortlet extends CPortlet
{
    public $model;


    public function init()
    {
        parent::init();

        if (!$this->model instanceof ActiveRecord)
        {
            throw new CException("Параметр model Должен быть объектом класса ActiveRecord");
        }


    }


    public function renderContent()
    {
        Yii::app()->clientScript->registerScriptFile('/js/comments/commentsPortlet.js');

        $this->render('CommentsPortlet', array(
            'model_id'  => get_class($this->model),
            'object_id' => $this->model->id
        ));
    }
}
