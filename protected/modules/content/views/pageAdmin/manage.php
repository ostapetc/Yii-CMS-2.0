<?
$this->tabs = [
    'Добавить страницу' => $this->createUrl('create')
];

$this->widget('AdminGridView', [
	'id'           => 'page-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
	'columns' => [
		[
			'name' => 'title',
			'type' => 'raw'
        ],
		[
            'name'   => 'status',
            'value'  => 'Page::$status_options[$data->status]',
            'filter' => Page::$status_options
        ],
        [
            'name'  => 'language',
            'value' => function ($data) {
                $languages = Language::getList();
                return $languages[$data->language];
            }
        ],
        'date_create',
		[
			'class'=>'CButtonColumn',
		],
	],
]);
?>




