<?

$this->tabs = array(
    'Добавить раздел страниц' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id'           => 'page-section-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
//    'sortable' => true,
	'columns' => array(
        'name',
        array(
            'name'  => 'parent_id',
            'value' => '$data->parent ? $data->parent->name : null'
        ),
        'date_create',
		array(
			'class'=>'CButtonColumn',
		),
	),
));
?>




