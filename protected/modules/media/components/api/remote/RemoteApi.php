<?php
class RemoteApi extends ApiAbstract
{
    public function findAll($criteria)
    {
        throw new CException('not implemented yet');
    }


    public function parse($content)
    {
        return false;
    }


    function count($criteria)
    {
        throw new CException('not implemented yet');
    }


    public function search($props = array())
    {
        throw new CException('not implemented yet');
    }


    public function save($props = array())
    {
        return true;
    }


    public function attributeNames()
    {
        return array(
            'title',
            'pk',
        );
    }


    public function findByPk($pk)
    {
        $this->beforeFind();
        $params = array(
            'pk'        => $pk
        );
        return $this->populateRecord($params);
    }


    protected function _populate($attributes)
    {
        $this->pk = $attributes['pk'];
    }

}