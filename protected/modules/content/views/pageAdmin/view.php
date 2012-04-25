<?
$this->page_title = t('Просмотр страницы');

$this->tabs = array(
    'редактировать'  => $this->createUrl('update', array('id' => $model->id)),
    'список страниц' => $this->createUrl('manage')
);

$languages = Language::getList();

$this->widget('AdminDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'title',
		'url',
		array(
            'name'  => 'is_published',
            'value' => $model->is_published ? t('Да') : t('Нет')
        ),
		array(
            'name'  => 'date_create',
            'value' => date('d.m.Y h:i', strtotime($model->date_create))
        ),
        array(
            'name'  => t('Мета-теги'),
            'value' => MetaTag::model()->html($model->id, get_class($model)),
            'type'  => 'raw'
        ),
        array(
            'name'  => 'language',
            'value' => $languages[$model->language]
        ),
		array(
            'name'  => 'text',
            'type'  => 'raw',
            'value' => $model->text
        ),
        array(
          'label' => 'Тэги',
          'type'  => 'raw',
          'value' => Tag::getString(get_class($model), $model->id)
      ),
	),
));
