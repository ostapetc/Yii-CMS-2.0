<?php
$this->page_title = "Просмотр Пользователя: {$model->name}";

$this->widget('DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'last_name',
        'first_name',
        'patronymic',
		'email',
		'birthdate',
		'phone',
		array(
			'name'  => 'role',
			'value' => $model->role->description
		),
		array(
			'name'  => 'gender',
			'value' => $model->gender == "man" ? "муж." : "жен."
		),
		array(
			'name'  => 'status',
			'value' => User::$status_list[$model->status]
		),
		'date_create'
	),
));
?>
