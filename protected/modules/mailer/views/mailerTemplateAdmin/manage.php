<?
$this->tabs = array(
    'Добавить шаблон' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id'           => 'email-template-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
	'columns' => array(
        'name',
        'subject',
        'date_create',
		array(
			'class'=>'CButtonColumn',
		),
	),
));
?>




