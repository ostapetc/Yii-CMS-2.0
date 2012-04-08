<?php

class Crud extends CFormModel
{
    public $model;


    public function rules()
    {
        return array(
            array('model', 'required')
        );
    }
}























