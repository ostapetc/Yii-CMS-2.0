<?php

if ($this->model->isNewRecord)
{
    $items = array();
}
else
{
    $model = $this->model->model_id;
    $items = array();

    $objects = $model::model()->findAll();
    foreach ($objects as $i => $object)
    {
        $items[$object->id] = (string) $object;
    }
}

return array(
    'activeForm' => array(
        'id' => 'meta-tag-form',
		'enableAjaxValidation' => true,
    ),
    'elements' => array(
        'model_id' => array(
            'type'     => 'dropdownlist',
            'items'    => AppManager::getModels(array('meta_tags' => true)),
            'prompt'   => 'не выбрана',
            'disabled' =>  $this->model->isNewRecord ? false : true
        ),
        'object_id' => array(
            'type'     => 'dropdownlist',
            'label'    => 'Объект',
            'items'    => $items,
            'disabled' =>  $this->model->isNewRecord ? false : true
        ),
        'title' => array(
            'type' => 'text'
        ),
        'description' => array(
            'type' => 'text'
        ),
        'keywords' => array(
            'type' => 'text'
        ),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить',
            'id'    => 'meta_tag_submit'
        )
    )
);


