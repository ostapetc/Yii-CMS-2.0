<?
$this->page_title = 'Задачи'; 

$this->widget('AdminGridView', array(
	'id' => 'task-grid',
	'dataProvider' => $model->search(AuthItem::TYPE_TASK),
	'filter'       => $model,
	'columns' => array(
        'name',
        'description',
        array('name' => 'allow_for_all', 'value' => '$data->allow_for_all ? "Да" : "Нет"'),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 

