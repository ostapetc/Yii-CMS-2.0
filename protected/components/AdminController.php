<?php
 
abstract class AdminController extends BaseController
{
    public $layout='//layouts/admin/main';

    public $footer;

    public $crumbs = array();

    public $tabs;

    public function filters()
    {
        return CMap::mergeArray(parent::filters(),array(
            'postOnly + delete'
        ));
    }

    public function beforeAction($action)
    {
        Yii::app()->bootstrap->init();

        if (Yii::app()->user->isGuest && ($action->id != 'login'))
        {
            $this->redirect(array('/admin/login'));
        }

        return parent::beforeAction($action);
    }
}
