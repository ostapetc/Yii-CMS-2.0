<?php
$this->page_title = 'Роли';

$this->tabs = array(
    "Создать роль" => $this->createUrl("create")
);

function tasksLink($role)
{
	return "<a href='/rbac/TaskAdmin/RolesTasks/role/{$role}'>перейти</a>";
}

$not_system_role = '!in_array($data->name, AuthItem::$system_roles)';

$this->widget('AdminGrid', array(
	'id' => 'news-grid',
	'dataProvider' => $model->search(AuthItem::TYPE_ROLE),
	'filter'   => $model,
    'sortable' => true,
	'columns'  => array(
        'name',
        'description',
		array('name' => 'tasks', 'value' => 'tasksLink($data->name)', 'type' => 'raw', 'filter' => false),
		array(
			'class' => 'CButtonColumn',
            'buttons' => array(
                'update' => array(
                    'visible' => $not_system_role
                ),
                'delete' => array(
                    'visible' => $not_system_role
                )
            )
		),
	),
)); 
?>
