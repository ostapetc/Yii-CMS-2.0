<?php
$this->page_title = $this->t('admin', 'manage');

$this->tabs = array(
    $this->t('admin', 'create') => $this->createUrl("create")
);

$this->widget('AdminGrid', array(
	'id'=>'news-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns'=>array(
		'title',
		array(
		    'name'  => 'user_id',
		    'value' => '$data->user->name'
		),
		array('name' => 'state', 'value' => 'News::$states[$data->state]'),
		'date',
        'date_create',
        array('name' => 'lang', 'value' => '$data->language->name'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
