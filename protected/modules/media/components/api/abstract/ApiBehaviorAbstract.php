<?php
abstract class ApiBehaviorAbstract extends CActiveRecordBehavior
{
    public $api_model;

    public $module;
    public $assets;

    public function __construct()
    {
        $this->module = Yii::app()->getModule('media');
        $this->assets = $this->module->assetsUrl();
    }


    abstract function getHref();


    abstract function getUrl();


    abstract function getIcon();


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
        if ($this->api_model === null)
        {
            $this->api_model = Yii::createComponent($this->api_model)->findByPk($this->getPk());
        }
        return $this->api_model;
    }

}

