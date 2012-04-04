<?
$this->tabs = array(
    'Добавить страницу' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id' => 'page-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
//    'sortable' => true,
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
        array(
            'name'  => 'language',
            'value' => function ($data) {
                $languages = Language::getCachedArray();
                return $languages[$data->language];
            }
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
));
?>




