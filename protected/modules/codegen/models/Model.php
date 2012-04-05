<?php

class Model extends CFormModel
{
    public $name;

    public $table;

    public $class;

    public $module;

    public $behaviors;


    public static $extra_behaviors = array(
        'Сортировка' => 'application.extensions.sortable.SortableBehavior',
        'Мета тэги'  => 'application.components.activeRecordBehaviors.MetaTagBehavior'
    );


    public function rules()
    {
        return array(
            array('name, class, table, module', 'required'),
            array('class', 'fileNotExists'),
            array('table', 'TableExists')
        );
    }


    public function fileNotExists($attr)
    {
        if (file_exists($this->path))
        {
            $this->addError($attr, "Файл '{$this->path}' уже существует");
        }
    }


    public function getPath()
    {
        return MODULES_PATH . $this->module . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $this->class . '.php';
    }
}























