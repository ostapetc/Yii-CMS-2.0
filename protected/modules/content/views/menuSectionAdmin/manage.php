<?php

function menuSectionInfo($section)
{
    $modules_urls = AppManager::getModulesClientMenu();

    $img_url = Yii::app()->getModule('content')->assetsUrl() . '/img/';

    $icons = array();

    if ($section->page_id)
    {
        $icons[] = "<img src='{$img_url}page.png' border='0' title='Привязка к странице: {$section->title}' />";
    }

    if ($section->module_url)
    {
        if (isset($modules_urls[$section->module_id][$section->module_url]))
        {
            $icons[] = "<img src='{$img_url}module.png' border='0' title='Привязка к модулю: {$modules_urls[$section->module_id][$section->module_url]}' />";
        }
        else
        {
            $icons[] = "<img src='{$img_url}module.png' style='border:2px dashed red' title='Неверная привязка к несуществующему разделу модуля!' />";
        }
    }

    if ($icons)
    {
        return implode('&nbsp;', $icons);
    }
}

$this->page_title = 'Разделы меню';

$this->tabs = array(
    "добавить раздел" => $this->createUrl('create', array(
        'menu_id'   => $menu->id,
        'parent_id' => $root->id,
        'back'      => 'manage'
    )),
    "сортировка"      => $this->createUrl('sorting', array(
        'root_id' => $root->id,
        'menu_id' => $menu->id
    )),
);

$this->widget('AdminGridView', array(
    'id'              => 'menu-section-grid',
    'dataProvider'    => $model->search($root->id),
    'filter'          => $model,
    'template'        => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
    'columns'         => array(
        array(
            'name'  => 'title',
            'value' => function ($data)
            {
                return CHtml::link($data->nbsp_title, Yii::app()->controller->createUrl("update", array(
                    "id"   => $data->id,
                    'back' => 'manage'
                )), array(
                    "level" => $data->level,
                    "class" => "node_link"
                ));
            },
            'type'  => 'raw'
        ), 'url', array(
            'header'      => 'Принадлежность',
            'type'        => 'raw',
            'value'       => 'menuSectionInfo($data)',
            'htmlOptions' => array('width' => '1px')
        ), array(
            'class'      => 'gridColumns.PublishedColumn',
            'name'       => 'is_published'
        ), array(
            'class'    => 'CButtonColumn',
            'template' => '{create} {update} {delete}',
            'buttons'  => array(
                'create' => array(
                    'label'    => 'добавить дочерний раздел',
                    'imageUrl' => '/img/admin/child.png',
                    'url'      => 'Yii::app()->controller->createUrl("create",array("menu_id" => $data->menu->id, "parent_id" => $data->id, "back" => "manage"))'
                ),
                'update' => array(
                    'url' => 'Yii::app()->controller->createUrl("update",array("id" => $data->id, "back" => "manage"))'
                )
            )
        ),
    ),

));
?>




