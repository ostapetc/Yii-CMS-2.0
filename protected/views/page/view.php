<? 
$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'language',
		'title',
		'url',
		'text',
		'is_published',
		'date_create',
		'order',
	),
)); 
?>

