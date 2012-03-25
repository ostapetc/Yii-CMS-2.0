<?

$this->tabs = array(
    'управление сайдбарами' => $this->createUrl('manage'),
    'редактировать'         => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'title'),
        array(
            'name'  => 'is_published',
            'value' => $model->is_published ? "Да" : "Нет"
        ),
        array(
            'name'  => 'language',
            'value' => $model->getLanguageName()
        ),
		array(
            'name' => 'html',
            'type' => 'raw'
        )
	),
)); 


