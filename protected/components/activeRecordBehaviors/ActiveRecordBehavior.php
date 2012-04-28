<?php
class ActiveRecordBehavior extends CActiveRecordBehavior
{
    public function events()
    {
        return array_merge(parent::events(), array(
            'onBeforeFormInit'=>'beforeFormInit',
            'onAfterFormInit'=>'afterFormInit',
            'onBeforeGridInitColumns'=>'beforeGridInitColumns',
            'onAfterGridInitColumns'=>'afterGridInitColumns',
            'onBeforeGridInit'=>'beforeGridInit',
            'onAfterGridInit'=>'afterGridInit',
        ));
    }

    public function beforeFormInit($event)
    {
    }


    public function afterFormInit($event)
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
