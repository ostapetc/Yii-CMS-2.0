<?php

class Model extends CFormModel
{
    public $name;

    public $table;

    public $class;

    public $behaviors;


    public static $extra_behaviors = array(
        'Сортировка' => 'application.extensions.sortable.SortableBehavior',
        'Мета тэги'  => 'application.components.activeRecordBehaviors.MetaTagBehavior'
    );


    public function rules()
    {
        return array(
            array('name, class, table', 'required')
        );
    }
}

