<style type="text/css">
    .node_padding {
        color: #c8d0d4;
    }

    .visibility_icon {
        cursor: pointer;
    }
</style>

<script type="text/javascript">

    $(function()
    {
        $('.node_link').each(function()
        {
            var level = parseInt($(this).attr('level'));
                level = (level - 2) * 5;

            var padding = '<span class="node_padding">' + new Array(level).join('-') + '</span>';

            $(this).before(padding);
        });


        $('.visibility_icon').live('click', function()
        {
            var src = $(this).attr('src');
            if (src.indexOf('eye.png') != -1)
            {
                $(this).attr('src', src.replace('eye.png', 'eye_na.png'));
                $(this).attr('title', 'Не виден в меню');
            }
            else
            {   $(this).attr('src', src.replace('eye_na.png', 'eye.png'));
                $(this).attr('title', 'Виден в меню');
            }

            $.post('/content/MenuSectionAdmin/updateVisibility/id/' + $(this).attr('section_id'));
        });
    });

</script>


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


function visibilityIcon($data)
{
    $img_url = Yii::app()->getModule('content')->assetsUrl() . '/img/';

    $icon  = $data->is_visible ? 'eye.png'      : 'eye_na.png';
    $title = $data->is_visible ? 'Виден в меню' : 'Не виден в меню';

    return "<img src='{$img_url}{$icon}' title='{$title}' class='visibility_icon' section_id='{$data->id}' />";
}


function sectionValue($data)
{
    return CHtml::link($data->title, Yii::app()->controller->createUrl("update", array("id" => $data->id, 'back' => 'manage')), array("level" => $data->level, "class" => "node_link"));
}


$this->page_title = 'Разделы меню';

$this->tabs = array(
    "добавить раздел" => $this->createUrl('create', array('menu_id' => $menu->id, 'parent_id' => $root->id, 'back' => 'manage')),
    "сортировка"      => $this->createUrl('sorting', array('root_id' => $root->id, 'menu_id' => $menu->id)),
);

$this->widget('AdminGridView', array(
	'id' => 'menu-section-grid',
	'dataProvider' => $model->search($root->id),
	'filter' => $model,
    'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
    'afterAjaxUpdate' => 'initMenuSectionsTree',
	'columns' => array(
        array(
            'name'  => 'title',
            'value' => 'sectionValue($data)',
            'type'  => 'raw'
        ),
		'url',
        array(
            'header'      => '',
            'type'        => 'raw',
            'value'       => 'menuSectionInfo($data)',
            'htmlOptions' => array('width' => '1px')
        ),
        array(
            'header'      => '',
            'type'        => 'raw',
            'value'       => 'visibilityIcon($data)',
            'htmlOptions' => array('width' => '1px')
        ),
        array(
			'class'=>'CButtonColumn',
            'template' => '{create} {update} {delete}',
            'buttons' => array(
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




