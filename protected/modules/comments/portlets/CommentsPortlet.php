<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 30.05.12
 * Time: 20:43
 * To change this template use File | Settings | File Templates.
 */

Yii::import('zii.widgets.CPortlet');

class CommentsPortlet extends Widget
{
    public $model;
    public $client_options = [];
    public $is_hidden = false;

    public function init()
    {
        parent::init();

        if ($this->model === null)
        {
            throw new CException("Параметр model является обязательным");
        }
    }


    public function run()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery.ui');
        $cs->registerScriptFile('/js/comments/commentsPortlet.js');
        $options = CJavaScript::encode($this->client_options);
        $cs->registerScript($this->id, "$('#{$this->id}').commentList($options)");

        if ($this->model === false)
        {
            $params = [
                'model_id'  => '',
                'object_id' => ''
            ];
        }
        else
        {
            $params = [
                'model_id'  => get_class($this->model),
                'object_id' => $this->model->id
            ];
        }

        $this->render('CommentsPortlet', $params);
    }
}
