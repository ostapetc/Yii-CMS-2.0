<?php

class TableExistsValidator extends CValidator
{
    public function validateAttribute($object, $attr)
    {
        $table  = addslashes($object->$attr);
        $exists = (bool) Yii::app()->db->createCommand("SHOW TABLES LIKE '{$table}'")->queryAll();

        if (!$exists)
        {
            $this->addError($object, $attr, "Таблица '{$table}' не существует!");
        }
    }
}
