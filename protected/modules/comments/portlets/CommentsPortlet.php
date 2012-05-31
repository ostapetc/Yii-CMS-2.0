<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 30.05.12
 * Time: 20:43
 * To change this template use File | Settings | File Templates.
 */
class CommentsPortlet extends Portlet
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
        $this->render('CommentsPortlet', array(
            'object' => Comment::defineObject($this->model)
        ));
    }
}
