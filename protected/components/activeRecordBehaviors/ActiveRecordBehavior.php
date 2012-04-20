<?php
class ActiveRecordBehavior extends CActiveRecordBehavior
{
    public function events()
    {
        return array_merge(parent::events(), array(
            'onBeforeInitForm'=>'beforeInitForm',
        ));
    }

    public function beforeInitForm($event)
    {
    }

}
