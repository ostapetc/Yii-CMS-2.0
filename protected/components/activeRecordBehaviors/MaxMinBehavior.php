<?
 
class MaxMinBehavior extends ActiveRecordBehavior
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
        $criteria = $this->getOwner()->getDbCriteria();
        $criteria->select = strtoupper($min_max) . "({$attr})";
        $cmd = Yii::app()->db->commandBuilder->createFindCommand($this->owner->tableName(), $criteria);
        return $cmd->queryScalar();
    }
}
