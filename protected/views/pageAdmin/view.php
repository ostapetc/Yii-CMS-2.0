<?

$this->tabs = array(
    'управление'    => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'language'),
		array('name' => 'title'),
		array('name' => 'url'),
		array('name' => 'text'),
		array('name' => 'is_published'),
		array('name' => 'date_create'),
		array('name' => 'order'),
	),
)); 


