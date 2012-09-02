<?php
class Crud extends FormModel
{
    /**
     * @var string sd
     */
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


    /**
     * @param $val
     */
    public function setNono($val)
    {

    }
}























