<?php
$this->page_title = t('Страницы сайта');
$this->widget('AdminGridView', array(
	'id' => 'page-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
    'sortable' => true,
	'columns' => array(
		array(
			'name' => 'title',
			'type' => 'raw'
		),
		'url',
		array(
            'class' => 'gridColumns.PublishedColumn',
			'name'  => 'is_published',
		),
        array('name' => 'lang', 'value' => '$data->language->name'),
		array(
			'class'=>'CButtonColumn',
		),
	),
));
?>




