<?php
abstract class ApiBehaviorAbstract extends CActiveRecordBehavior
{
    public $assets;
    public $sizes = [];


    abstract public function getType();


    abstract function getHref();


    abstract function parse($source);


    abstract function getPreview($size_name = null);


    protected function getPk()
    {
        return $this->getOwner()->remote_id;
    }


    protected function setPk($pk)
    {
        $this->getOwner()->remote_id = $pk;
    }


}

