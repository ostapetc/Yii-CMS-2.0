<?php
abstract class ApiDataProviderAbstract extends CActiveDataProvider
{
    private $_criteria;
    protected $criteriaClass;

    public function __construct($model,$config=array())
    {
        $modelClass = get_class($model);
        $this->model = $model;
        $this->modelClass = $modelClass;
        parent::__construct($model, $config);
    }

    public function getCriteria()
    {
        if($this->_criteria===null)
            $this->_criteria=new $this->criteriaClass;
        return $this->_criteria;
    }

    public function setCriteria($value)
    {
        $this->_criteria=$value instanceof $this->criteriaClass ? $value : new $this->criteriaClass($value);
    }

    public function getSort()
    {
        return false;
    }

    protected function fetchData()
    {
        $criteria=clone $this->getCriteria();

        if(($pagination=$this->getPagination())!==false)
        {
            $pagination->setItemCount($this->getTotalItemCount());
            $pagination->applyLimit($criteria);
        }

        $baseCriteria=$this->model->getDbCriteria(false);

        $this->model->setDbCriteria($baseCriteria!==null ? clone $baseCriteria : null);
        $data=$this->model->findAll($criteria);
        $this->model->setDbCriteria($baseCriteria);  // restore original criteria
        return $data;
    }
}