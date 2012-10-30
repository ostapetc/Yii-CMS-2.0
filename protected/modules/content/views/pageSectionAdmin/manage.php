<?

$this->tabs = [
    'Добавить раздел страниц' => $this->createUrl('create')
];

$this->widget('AdminGridView', [
	'id'           => 'page-section-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
//    'sortable' => true,
	'columns' => [
        'name',
        [
            'name'  => 'parent_id',
            'value' => '$data->parent ? $data->parent->name : null'
        ],
        'date_create',
		[
			'class'=>'CButtonColumn',
		],
    ],
]);



