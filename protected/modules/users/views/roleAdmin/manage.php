<?
$this->page_title = 'Управление ролями пользователей';

$this->widget('AdminGridView', array(
	'id'=>'role-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'description',
		array('name' => 'privileged', 'value' => '$data->privileged ? \'Да\' : \'Нет\''),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
