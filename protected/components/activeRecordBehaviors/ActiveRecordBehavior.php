<?php
class ActiveRecordBehavior extends CActiveRecordBehavior
{
    public function events()
    {
        return array_merge(parent::events(), array(
            'onInitFormElements'=>'initFormElements',
        ));
    }

    public function initFormElements($event)
    {
    }

}
