<?php

$sections = ArticleSection::model()->findAllByAttributes(array('parent_id' => null));

if (!$this->model->isNewRecord)
{
    foreach ($sections as $i => $section)
    {
        if ($section->id == $this->model->id)
        {
            unset($sections[$i]);
            break;
        }
    }
}

return array(
    'activeForm' => array(
        'id'                   => 'article-form',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'name'       => array('type' => 'text'),
        'parent_id'  => array(
            'type'   => 'dropdownlist',
            'prompt' => 'отсутствует',
            'items'  => CHtml::listData($sections, 'id', 'name')
        ),
        'in_sidebar' => array('type' => 'checkbox')
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Создать' : 'Сохранить'
        ),
    )
);
