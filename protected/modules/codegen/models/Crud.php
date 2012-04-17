<?php

class Crud extends CFormModel
{
    public $class;

    public $genetive;

    public $instrumental;

    public $accusative;


    public function rules()
    {
        return array(
            array('class, genetive, instrumental, accusative', 'required')
        );
    }
}























