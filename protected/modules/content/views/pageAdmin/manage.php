<?php
$this->page_title = t('Страницы сайта');

$this->widget('bootstrap.widgets.BootGridView', array(
	'id' => 'page-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
    'template'=>"{items}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'name' => 'title',
			'type' => 'raw'
		),
		'url',
		array(
			'name'  => 'is_published',
			'value' => '$data->is_published ? t("Да") : t("Нет")'
		),
        array('name' => 'lang', 'value' => '$data->language->name'),		
		array(
			'class'=>'CButtonColumn',
		),
	),
));



Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You successfully read this important alert message.');
Yii::app()->user->setFlash('info', '<strong>Heads up!</strong> This alert needs your attention, but it\'s not super important.');
Yii::app()->user->setFlash('warning', '<strong>Warning!</strong> Best check yo self, you\'re not looking too good.');
Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>





