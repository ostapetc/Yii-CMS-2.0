<?php

//class TableExists extends CValidator
//{
//    public function validateAttribute($object, $attr)
//    {
//        $table  = addslashes($object->$attr);
//        $exists = (bool) Yii::app()->db->createCommand("SHOW TABLES LIKE '{$table}'")->queryAll();
//
//        if (!$exists)
//        {
//            $this->addError($attr, $object, "Таблица '{$table}' не существует!");
//        }
//    }
//}
