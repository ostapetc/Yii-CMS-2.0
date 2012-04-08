<?
$this->page_title = 'Управление пользователями';

$this->widget('AdminGridView', array(
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
			'value' => 'is_numeric($data->gender) ? User::$gender_list[$data->gender] : ""'
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

