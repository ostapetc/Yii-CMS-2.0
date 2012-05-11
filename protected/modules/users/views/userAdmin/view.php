<?
$this->page_title = "Просмотр Пользователя: {$model->name}";

$this->widget('BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'email',
		'birthdate',
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
