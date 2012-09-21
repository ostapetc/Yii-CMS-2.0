<?php
class YouTubeDataProvider extends CActiveDataProvider
{
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

    public function getSort()
    {
        return false;
    }
}