<?php
abstract class ApiBehaviorAbstract extends CActiveRecordBehavior
{
    public $api_model;


    abstract function getHref();


    abstract function getUrl();


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
        $owner = $this->getOwner();
        if ($owner->api_model === null)
        {
            $owner->api_model = Yii::createComponent($this->api_model);
        }
        return $owner->api_model;
    }
}

