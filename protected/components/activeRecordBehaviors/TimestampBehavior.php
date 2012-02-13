<?php
 
class TimestampBehavior extends CActiveRecordBehavior
{
    public function beforeSave($event)
    {
        $model = $this->getOwner();

        if ($model->isNewRecord)
        {
            if (array_key_exists('date_create', $model->attributes))
            {
                $model->date_create = new CDbExpression('NOW()');
            }
        }
        else
        {
            if (array_key_exists('date_update', $model->attributes))
            {
                $model->date_update = new CDbExpression('NOW()');
            }
        }

        return parent::beforeSave($event);
    }
}
