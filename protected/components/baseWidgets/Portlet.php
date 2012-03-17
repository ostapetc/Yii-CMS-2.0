<?php
Yii::import('zii.widgets.CPortlet');

abstract class Portlet extends CPortlet
{
//    public $cache_id;

    public function init()
    {
        $this->attachBehaviors($this->behaviors());
        parent::init();
    }

    public function behaviors()
    {
        return array(
            'CoomponentInModule' => array(
                'class' => 'application.components.behaviors.ComponentInModuleBehavior'
            )
        );
    }

//    public function run()
//    {
//        if ($this->cache_id && $res = Yii::app()->cache->get($this->cache_id))
//        {
//            return $res;
//        }
//        $res = parent::run();
//        if ($this->cache_id)
//        {
//            Yii::app()->cache->set($this->cache_id, $res, 60);
//        }
//        return $res;
//    }
//
}
