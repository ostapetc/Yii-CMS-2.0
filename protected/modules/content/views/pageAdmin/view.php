<?
$this->page_title = t('Просмотр страницы');

$this->tabs = [
    'редактировать'  => $this->createUrl('update', ['id' => $model->id]),
    'список страниц' => $this->createUrl('manage')
];

$languages = Language::getList();

$this->widget('AdminDetailView', [
	'data'=>$model,
	'attributes'=> [
        'title',
		'url',
		[
            'name'  => 'date_create',
            'value' => date('d.m.Y h:i', strtotime($model->date_create))
        ],
        [
            'label'  => t('Мета-теги'),
            'value' => MetaTag::model()->html($model->id, get_class($model)),
            'type'  => 'raw'
        ],
        [
            'name'  => 'language',
            'value' => $languages[$model->language]
        ],
		[
            'name'  => 'text',
            'type'  => 'raw',
            'value' => $model->text
        ],
        [
          'label' => 'Тэги',
          'type'  => 'raw',
          'value' => Tag::getString(get_class($model), $model->id)
        ],
    ],
]);
