<?php
class YouTubeDataProvider extends CActiveDataProvider
{
    private $_criteria;

    /**
     * @var Zend_Gdata_YouTube
     */

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
            $this->_criteria=new YouTubeApiCriteria;
        return $this->_criteria;
    }

    public function setCriteria($value)
    {
        $this->_criteria=$value instanceof YouTubeApiCriteria ? $value : new CDbCriteria($value);
    }

    public function getSort()
    {
        return false;
    }
}