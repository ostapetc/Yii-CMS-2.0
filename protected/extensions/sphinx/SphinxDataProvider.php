<?php
class SphinxDataProvider extends CArrayDataProvider
{
    public $response;


    public function __construct($response, $config = array())
    {
        $this->response = $response;
        $matches        = array();
        foreach ($this->response['matches'] as $id => $data)
        {
            $match = new stdClass();
            foreach ($data['attrs'] as $key => $value)
            {
                $match->$key = $value;
            }
            $match->id      = $id;
            $match->model   = ActiveRecord::model($match->model_id)->findByPk($match->object_id);
            $match->_weight = $data['weight'];
            $matches[$id]   = $match;
        }
        parent::__construct($matches, $config);
    }

}