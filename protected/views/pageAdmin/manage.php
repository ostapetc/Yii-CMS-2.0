<?

$this->tabs = array(
    'добавить' => $this->createUrl('create')
);

$this->widget('GridView', array(
	'id' => 'page-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'language'),
		array('name' => 'title'),
		array('name' => 'url'),
		array('name' => 'text'),
		array('name' => 'is_published'),
		array('name' => 'date_create'),
		/*
		array('name' => 'order'),
		*/
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 

