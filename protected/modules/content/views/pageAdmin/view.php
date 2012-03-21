<?php
$this->page_title = t('Просмотр страницы');

$this->tabs = array(
    'редактировать'  => $this->createUrl('update', array('id' => $model->id)),
    'список страниц' => $this->createUrl('manage')
);

$languages = Language::getCachedArray();

$this->widget('BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'title',
		'url',
		array(
            'name'  => 'is_published',
            'value' => $model->is_published ? t('Да') : t('Нет')
        ),
        array(
            'name'  => 'on_main',
            'value' => $model->on_main ? t("Да") : t("Нет")
        ),
		array(
            'name'  => 'date_create',
            'value' => date('d.m.Y h:i', strtotime($model->date_create))
        ),
        array(
            'name'  => 'left_menu_id',
            'label' => 'Меню слева',
            'value' => $model->left_menu_id ? $model->left_menu->name : 'не выводится'
        ),
        array(
            'name'  => 'widget',
            'value' => $model->widget ? Page::$widgets[$model->widget] : null
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
            'name'  => 'short_text',
            'type'  => 'raw',
        ),
		array(
            'name'  => 'text',
            'type'  => 'raw',
            'value' => $model->text
        ),
	),
));
?>
