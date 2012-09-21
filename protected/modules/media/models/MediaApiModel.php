<?php
abstract class MediaApiModel extends CModel
{
    protected $dbCriteria;

    abstract function findAll($criteria);


    abstract function findByPk($pk);


    abstract function count($criteria);


    abstract protected function _populate($attributes);


    public function behaviors()
    {
        return array();
    }


    public function init()
    {

    }


    public function getDbCriteria()
    {
        return $this->dbCriteria;
    }


    public function setDbCriteria($criteria)
    {
        $this->dbCriteria = $criteria;
    }
    protected function instantiate($attributes)
    {
        $class = get_class($this);
        $model = new $class(null);
        return $model;
    }


    public function populateRecord($attributes, $callAfterFind = true)
    {
        if ($attributes !== false)
        {
            $record = $this->instantiate($attributes);
            $record->setScenario('update');
            $record->init();
            $record->_populate($attributes);
            $record->attachBehaviors($record->behaviors());
            if ($callAfterFind)
            {
                $record->afterFind();
            }
            return $record;
        }
        else
        {
            return null;
        }
    }


    public function populateRecords($data, $callAfterFind = true, $index = null)
    {
        $records = array();
        foreach ($data as $attributes)
        {
            if (($record = $this->populateRecord($attributes, $callAfterFind)) !== null)
            {
                if ($index === null)
                {
                    $records[] = $record;
                }
                else
                {
                    $records[$record->$index] = $record;
                }
            }
        }
        return $records;
    }


    public function afterFind()
    {
    }


    public function beforeFind()
    {
    }
}

