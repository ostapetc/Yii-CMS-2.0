<?php
$this->page_title = $this->t('admin', 'view');

$this->tabs = array(
    $this->t('admin', 'manage') => $this->createUrl('manage'),
    $this->t('admin', 'update') => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'title'),
		array('name' => 'lang', 'value' => $model->language->name),
		array(
		'name'  => 'user_id', 
		'value' => $model->user->name
		),
		array(
			'name'  => 'photo', 
			'value' => ImageHelper::thumb(News::PHOTOS_DIR, $model->photo, News::PHOTO_SMALL_WIDTH), 
			'type'  => 'raw'
		),
		array(
			'name'  => 'state', 
			'value' => News::$states[$model->state]
		),
		'date',
		'date_create',
        array(
            'header'  => 'Мета-теги',
            'value' => MetaTag::model()->html($model->id, get_class($model)),
            'type'  => 'raw'
        ),
		array(
			'name' => 'text', 
			'type' => 'raw'
		)
	),
)); 
?>
