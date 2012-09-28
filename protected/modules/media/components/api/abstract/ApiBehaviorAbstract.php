<?php
abstract class ApiBehaviorAbstract extends CActiveRecordBehavior
{
    public $api_model;
    protected $_api_model;

    public $module;
    public $assets;

    public function __construct()
    {
        $this->module = Yii::app()->getModule('media');
        $this->assets = $this->module->assetsUrl();
    }


    abstract function getHref();


    abstract function getUrl();


    abstract function getPreview();


    protected function getPk()
    {
        return $this->getOwner()->remote_id;
    }


    protected function setPk($pk)
    {
        $this->getOwner()->remote_id = $pk;
    }


    /**
     * @return ApiAbstract
     */
    public function getApiModel()
    {
        if ($this->_api_model === null)
        {
            $this->_api_model = Yii::createComponent($this->api_model);
            if ($this->getPk())
            {
                $this->_api_model = $this->_api_model->findByPk($this->getPk());
            }
        }
        return $this->_api_model;
    }


    public function setApiModel($model)
    {
        $this->_api_model = $model;
    }
}

