<?
$this->page_title = t('Страницы сайта');

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
            'name'  => 'language',
            'value' => function ($data) {
                $languages = Language::getList();
                return $languages[$data->language];
            }
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
));
?>




