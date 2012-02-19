<?php

Yii::app()->clientScript->registerScriptFile(
    Yii::app()->getModule('content')->assetsUrl() . '/js/MenuSectionForm.js');

$modules_urls = AppManager::getModulesClientMenu();
$res          = array();
foreach ($modules_urls as $module => $links)
{
    foreach ($links as $url => $title)
    {
        $title_arr = explode(':', $title);
        $module_id = $module;
        if (count($title_arr) > 1)
        {
            list($title, $part) = $title_arr;
            if ($part)
            {
                $module_id = $module . '-' . $part;
            }
        }
        $res['module:' . $module_id . ':' . $url] = $title;
    }
}

$modules_urls = $res;
foreach (CHtml::listData(Page::model()->findAll(), 'id', 'title') as $id=> $title)
{
    $modules_urls['page:' . $id] = $title;
}
$elements = array(
    'is_visible'     => array('type' => 'checkbox'),
    'url_info'       => array(
        'type'       => 'chosen',
        'onchange'   => 'js:function(){alert($("#this").val());}',
        'items'      => $modules_urls,
        'empty'      => 'Отсутствует',
        'label'      => 'На какую страницу ведет пункт меню'
    ),
    'title'          => array('type' => 'text'),
    'url'            => array('type' => 'text'),
);

return array(
    'activeForm' => array(
        'id' => 'menu-link-form'
    ),
    'elements'   => $elements,
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Добавить' : 'Сохранить'
        )
    )
);
