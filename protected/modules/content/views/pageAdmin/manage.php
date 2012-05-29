<?
$this->tabs = array(
    'Добавить страницу' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id'           => 'page-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
	'columns' => array(
		array(
			'name' => 'title',
			'type' => 'raw'
		),
		array(
            'name'   => 'status',
            'value'  => 'Page::$status_options[$data->status]',
            'filter' => Page::$status_options
        ),
        array(
            'name'  => 'language',
            'value' => function ($data) {
                $languages = Language::getList();
                return $languages[$data->language];
            }
        ),
        'date_create',
		array(
			'class'=>'CButtonColumn',
		),
	),
));
?>




