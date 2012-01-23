<?php

if ($this->model->scenario == 'ClientSide')
{
    $sections = FaqSection::model()->published()->findAll();
}
else
{
    $sections = FaqSection::model()->findAll();
}

if (count($sections) == 1)
{
    $section_id = array(
        'type'  => 'hidden',
        'value' => $sections[0]->id
    );
}
else
{
    $section_id = array(
        'type'  => 'dropdownlist',
        'items' => CHtml::listData($sections, "id", "name")
    );
}

$elements = array(
    'section_id' => $section_id,
    'first_name' => array('type' => 'text'),
    'last_name'  => array('type' => 'text'),
    'patronymic' => array('type' => 'text'),
    'company'    => array('type' => 'text'),
    'position'   => array('type' => 'text'),
    'phone'      => array('type' => 'text'),
    'email'      => array('type' => 'text'),
    'question'   => array(
        'type' => $this->model->scenario ==
            'ClientSide' ? 'textarea' : 'application.extensions.tiny_mce.TinyMCE'
    )
);

if ($this->model->scenario != 'ClientSide')
{
    $elements['answer']       = array('type' => 'application.extensions.tiny_mce.TinyMCE');
    $elements['is_published'] = array('type' => 'checkbox');

    unset($elements["first_name"]);
    unset($elements["last_name"]);
    unset($elements["patronymic"]);
    unset($elements["company"]);
    unset($elements["position"]);
    unset($elements["phone"]);
    unset($elements["email"]);
}

return array(
    'activeForm' => array(
        'id'                   => 'faq-form',
        'class'                => 'CActiveForm',
        'enableAjaxValidation' => true,
    ),
    'elements'   => $elements,
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Отправить'
        ),
    )
);
