<style type="text/css">
    .button-column {
        width: 100px !important;
    }
</style>

<?
$this->page_title = 'Меню сайта'; 

$this->tabs = [
	'добавить меню' => $this->createUrl('create')
];

$this->widget('AdminGridView', [
	'id' => 'menu-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=> [
		[
            'name'  => 'name',
            'value' => 'Chtml::link($data->name, array("/content/MenuSectionAdmin/manage", "menu_id" => $data->id))',
            'type'  => 'raw'
        ],
        ['name' => 'code'],
        [
            'name'   => 'is_published',
            'value'  => '$data->is_published ? "Да" : "Нет"',
            'filter' => [0 => 'Нет', 1 => 'Да']
        ],
        [
            'name'  => 'language',
            'value' => '$data->getLanguageName()'
        ],
		[
			'class'    => 'CButtonColumn',
            'template' => '{manage} {update}',
            'buttons'  => [
                'manage' => [
                    'label'    => 'управление разделами',
                    'imageUrl' => $this->module->assetsUrl() . '/img/manage.png',
                    'url'      => 'Yii::app()->createUrl("content/MenuSectionAdmin/manage", ["menu_id" => $data->id])'
                ],
//                'links' => [
//                    'label'    => 'ссылки',
//                    'imageUrl' => $this->module->assetsUrl() . '/img/tree.png',
//                    'url'      => 'Yii::app()->createUrl("content/MenuSectionAdmin/index", ["menu_id" => $data->id])'
//                ]
            ],
		],
    ],
]);

