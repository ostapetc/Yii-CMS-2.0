<?php
 
class MaxMinBehavior extends CActiveRecordBehavior
{
    public function max($attr)
    {
        return $this->_getMinOrMax($attr, 'max');
    }


    public function min($attr)
    {
        return $this->_getMinOrMax($attr, 'min');
    }


    private function _getMinOrMax($attr, $min_max)
    {
        $sql = "SELECT " . strtoupper($min_max) . "(`{$attr}`)
                      FROM `" . $this->owner->tableName() . "`";

        $res = Yii::app()->db->createCommand($sql)->queryColumn();
        if ($res)
        {
            return $res[0];
        }
    }
}
