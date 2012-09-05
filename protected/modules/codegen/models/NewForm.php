<?php
/** 
 * @property        $model
 * 
 */

class NewForm extends FormModel
{
    public $model;


    public function rules()
    {
        return array(
            array('model', 'required')
        );
    }
}























