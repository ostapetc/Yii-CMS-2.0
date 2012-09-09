<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property  $id
 * @property  $name
 * @property  $description
 * 
 */

class Module extends FormModel
{
    public $id;

    public $name;

    public $description;


    public function rules()
    {
        return array(
            array('id, name, description', 'required') ,
            array('id', 'idUnique'),
        );
    }


    public function idUnique($attr)
    {
        $dir = MODULES_PATH . $this->$attr;
        if (is_dir($dir))
        {
            $this->addError($attr, "Директория '{$dir}' уже существует!" );
        }
    }
}

