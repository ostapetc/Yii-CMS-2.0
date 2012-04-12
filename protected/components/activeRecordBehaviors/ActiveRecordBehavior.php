<?php
class ActiveRecordBehavior extends CActiveRecordBehavior
{
    public function events()
    {
        return array_merge(parent::events(), array(
            'onBeforeFormRender'=>'beforeFormRender',
        ));
    }

    public function beforeFormRender($event)
    {
    }

}
