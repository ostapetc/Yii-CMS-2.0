<?php
$this->page_title = 'Управление ролями пользователей';

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
);

$this->widget('AdminGrid', array(
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
