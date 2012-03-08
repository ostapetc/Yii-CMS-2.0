<?php
$this->page_title = t('Просмотр страницы');

$this->tabs = array(
    'редактировать'  => $this->createUrl('update', array('id' => $model->id)),
    'список страниц' => $this->createUrl('manage')
);

$this->widget('AdminDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'title',
		array('name' => 'lang', 'value' => $model->language->name),
		'url',
		array(
            'name'  => 'is_published',
            'value' => $model->is_published ? t('да') : t('нет')
        ),
		'date_create',
        array(
            'heared'  => t('Мета-теги'),
            'value' => MetaTag::model()->html($model->id, get_class($model)),
            'type'  => 'raw'
        ),
		array(
            'name'  => 'text',
            'type'  => 'raw',
            'value' => $model->text
        ),
	),
));
?>
