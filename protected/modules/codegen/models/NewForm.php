<?php

class NewForm extends CFormModel
{
    public $model;


    public function rules()
    {
        return array(
            array('model', 'required')
        );
    }
}























