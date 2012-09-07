<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property        $model
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
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























