<?php
$this->page_title = 'Управление пользователями';

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
);

$this->widget('AdminGrid', array(
	'id' => 'user-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'last_name',
        'first_name',
        'patronymic',
		'email',
		'birthdate',
		array(
			'name'  => 'gender',
			'value' => 'User::$gender_list[$data->gender]'
		),
		array(
			'name'  => 'status', 
            'value' => 'User::$status_list[$data->status]'
		),
		'phone',
		array(
			'name'  => 'role',
			'value' => 'isset($data->role->description) ? $data->role->description : null'
		),
		'date_create',
		array(
			'class' => 'CButtonColumn',
		),
	),
));
?>

