<?php

class NullValueBehavior extends CActiveRecordBehavior
{
    public function beforeSave()
    {
        $model = $this->getOwner();

        $columns = Yii::app()->db->getSchema()->getTable($model->tableName())->columns;

        foreach ($model->attributes as $name => $value)
        {
            if (!$value && $columns[$name]->allowNull)
            {
                $model->$name = null;
            }
        }
    }
}
