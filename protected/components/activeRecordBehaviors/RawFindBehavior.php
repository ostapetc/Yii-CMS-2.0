<?php
/**
 * Клас предоставляет функции выбора "сырых" данных в виде массивов, используя синтаксис AR
 */
class RawFindBehavior extends CActiveRecordBehavior
{
    public function findAllRaw($condition='',$params=array())
    {
        $owner = $this->getOwner();
        /**@var CDbCriteria $criteria*/
        $criteria = $owner->getDbCriteria();
        $criteria->mergeWith(array(
            'condition' => $condition,
            'params' => $params
        ));
        return $owner->getCommandBuilder()->createFindCommand($owner->tableSchema, $criteria)->queryAll();
    }

    public function findRaw($condition='',$params=array())
    {
        $owner = $this->getOwner();
        /**@var CDbCriteria $criteria*/
        $criteria = $owner->getDbCriteria();
        $criteria->mergeWith(array(
            'condition' => $condition,
            'params' => $params
        ));
        return $owner->getCommandBuilder()->createFindCommand($owner->tableSchema, $owner->dbCriteria)->queryRow();
    }


    public function findByPkRaw($pk,$condition='',$params=array())
    {
        $owner = $this->getOwner();
        Yii::trace(get_class($this).'.findByPkRaw()','components.activeRecordBehaviors.RawFindBehavior');
        $prefix=$owner->getTableAlias(true).'.';
        $criteria=$owner->getCommandBuilder()->createPkCriteria($owner->getTableSchema(),$pk,$condition,$params,$prefix);
        $owner->getDbCriteria()->mergeWith($criteria);
        return $owner->findRaw();
    }

    public function findAllByPkRaw($pk,$condition='',$params=array())
    {
        $owner = $this->getOwner();
        Yii::trace(get_class($this).'.findAllByPkRaw()','components.activeRecordBehaviors.RawFindBehavior');
        $prefix=$owner->getTableAlias(true).'.';
        $criteria=$owner->getCommandBuilder()->createPkCriteria($owner->getTableSchema(),$pk,$condition,$params,$prefix);
        $owner->getDbCriteria()->mergeWith($criteria);
        return $owner->findAllRaw();
    }

    public function findByAttributesRaw($attributes,$condition='',$params=array())
    {
        $owner = $this->getOwner();
        Yii::trace(get_class($this).'.findByAttributesRaw()','components.activeRecordBehaviors.RawFindBehavior');
        $prefix=$owner->getTableAlias(true).'.';
        $criteria=$this->getCommandBuilder()->createColumnCriteria($owner->getTableSchema(),$attributes,$condition,$params,$prefix);
        $owner->getDbCriteria()->mergeWith($criteria);
        return $owner->findRaw();
    }

    public function findAllByAttributesRaw($attributes,$condition='',$params=array())
    {
        $owner = $this->getOwner();
        Yii::trace(get_class($this).'.findAllByAttributesRaw()','components.activeRecordBehaviors.RawFindBehavior');
        $prefix=$owner->getTableAlias(true).'.';
        $criteria=$owner->owner->getCommandBuilder()->createColumnCriteria($owner->getTableSchema(),$attributes,$condition,$params,$prefix);
        $owner->getDbCriteria()->mergeWith($criteria);
        return $owner->findAllRaw();
    }
}