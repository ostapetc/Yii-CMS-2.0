<?php

echo t('Скрыть');
echo t('Система');


$this->page_title = t('Страницы сайта');
$this->widget('AdminGridView', array(
	'id' => 'page-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
    'sortable' => true,
	'columns' => array(
		array(
			'name' => 'title',
			'type' => 'raw'
		),
		'url',
		array(
			'name'  => 'is_published',
			'value' => '$data->is_published ? t("Да") : t("Нет")',
			'filter' => array(t("Нет"),t("Да"))
		),
        array('name' => 'lang', 'value' => '$data->language->name'),
		array(
			'class'=>'CButtonColumn',
		),
	),
));
?>




