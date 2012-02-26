<?php
$this->page_title = 'Разделы меню';

$this->tabs = array(
    "добавить раздел" => $this->createUrl('create', array(
        'menu_id' => $menu->id,
        'parent_id' => $root->id,
        'back' => 'manage'
    )),
    "сортировка" => $this->createUrl('sorting', array(
        'root_id' => $root->id,
        'menu_id' => $menu->id
    )),
);

$this->widget('AdminGridView', array(
    'id' => 'menu-section-grid',
    'dataProvider' => $model->search($root->id),
    'filter' => $model,
    'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
    'columns' => array(
        array(
            'name' => 'title',
            'value' => function ($data)
            {
                return CHtml::link($data->nbsp_title, Yii::app()->controller->createUrl("update", array(
                    "id" => $data->id,
                    'back' => 'manage'
                )), array(
                    "level" => $data->level,
                    "class" => "node_link"
                ));
            },
            'type' => 'raw'
        ), 'url', array(
            'header' => 'Принадлежность',
            'type' => 'raw',
            'value' => function($data, $row)
            {
                $img_url = Yii::app()->getModule('content')->assetsUrl() . '/img';

                $src = '';
                $htmlOptions = array();

                if ($data->page_id)
                {
                    $src = $img_url . '/page.png';
                    $htmlOptions['title'] = 'Привязка к странице: ' . $data->title;
                }
                elseif ($data->module_url)
                {
                    $src = $img_url . '/module.png';

                    $modules_urls = AppManager::getModulesClientMenu();
                    if (isset($modules_urls[$data->module_id][$data->module_url]))
                    {
                        $htmlOptions['title'] = 'Привязка к модулю: ' . $modules_urls[$data->module_id][$data->module_url];
                    }
                    else
                    {
                        $htmlOptions['title'] = 'Неверная привязка к несуществующему разделу модуля!';
                        $htmlOptions['style'] = 'border:2px dashed red';
                    }
                }

                if ($src)
                {
                    return CHtml::image($src, $htmlOptions['title'], $htmlOptions);
                }
            },
            'htmlOptions' => array('width' => '1px')
        ), array(
            'class' => 'gridColumns.PublishedColumn',
            'name' => 'is_published'
        ), array(
            'class' => 'CButtonColumn',
            'template' => '{create} {update} {delete}',
            'buttons' => array(
                'create' => array(
                    'label' => 'добавить дочерний раздел',
                    'imageUrl' => '/img/admin/child.png',
                    'url' => 'Yii::app()->controller->createUrl("create",array("menu_id" => $data->menu->id, "parent_id" => $data->id, "back" => "manage"))'
                ),
                'update' => array(
                    'url' => 'Yii::app()->controller->createUrl("update",array("id" => $data->id, "back" => "manage"))'
                )
            )
        ),
    ),

));
?>




