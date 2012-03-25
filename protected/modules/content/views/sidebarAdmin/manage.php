<?

$this->tabs = array(
    'добавить сайдбар' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id'           => 'sidebar-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
    'sortable'     => true,
	'columns' => array(
		array('name' => 'title'),
        array(
            'name'  => 'is_published',
            'value' => '$data->is_published ? "Да" : "Нет"'
        ),
        array(
            'name'   => 'language',
            'filter' => Language::getCachedArray(),
            'value'  => '$data->getLanguageName()'
        ),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 

