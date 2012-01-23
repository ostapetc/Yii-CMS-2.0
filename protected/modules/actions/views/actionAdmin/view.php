<?php
$this->page_title = 'Просмотр мероприятия';

$this->tabs = array(
    "управление мероприятиями"  => $this->createUrl('manage'),
    "редактировать" => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		'name',
		array('name' => 'lang', 'value' => $model->language->name),
		'place',
		'desc',
		array(
            'name'  => 'image',
            'value' => ImageHelper::thumb(Action::IMG_DIR, $model->image, Action::IMG_SMALL_WIDTH),
            'type'  => 'raw'
        ),
		'date',
		'date_create',
	),
)); 
?>
