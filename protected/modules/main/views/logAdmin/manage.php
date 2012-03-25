<? $this->page_title = 'Просмотр логов'; ?>

<?
$this->widget('AdminGridView', array(
	'id' => 'grid',
	'dataProvider' => $model->search(),
    'filter' => $model,
	'columns' => array(
		array('name' => 'message'),
		'level',
        array('name' => 'logtime', 'filter' => false),
        array(
            'class'    => 'CButtonColumn',
            'template' => ''
        )
	),
));
?>