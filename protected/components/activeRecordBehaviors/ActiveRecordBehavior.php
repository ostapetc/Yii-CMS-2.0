<?php
class ActiveRecordBehavior extends CActiveRecordBehavior
{
    public function events()
    {
        return array_merge(parent::events(), array(
            'onBeforeInitForm'=>'beforeInitForm',
            'onAfterInitForm'=>'afterInitForm',
            'onBeforeGridInitColumns'=>'beforeGridInitColumns',
            'onAfterGridInitColumns'=>'afterGridInitColumns',
            'onBeforeGridInit'=>'beforeGridInit',
            'onAfterGridInit'=>'afterGridInit',
        ));
    }

    public function beforeInitForm($event)
    {
    }


    public function afterInitForm($event)
    {
    }

    public function beforeGridInitColumns($event)
    {
    }

    public function afterGridInitColumns($event)
    {
    }


    public function beforeGridInit($event)
    {
    }

    public function afterGridInit($event)
    {
    }
}
