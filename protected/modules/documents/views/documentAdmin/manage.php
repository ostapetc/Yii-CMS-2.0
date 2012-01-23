<?php
$this->page_title = 'Управление документами';

$this->tabs = array(
    "добавить документ" => $this->createUrl('create')
);

$this->widget('AdminGrid', array(
	'id'=>'document-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		array('name' => 'is_published', 'value' => '$data->is_published ? "Да" : "Нет"'),
		'date_publish',
		'date_create',
        array('name' => 'lang', 'value' => '$data->language->name'),		
		array(
			'name'   => 'files',
			'value'  => '"
						<a href=\'/documents/documentFileAdmin/manage/document_id/$data->id\'>просмотр</a>&nbsp;|&nbsp;
						<a href=\'/documents/documentFileAdmin/create/document_id/$data->id\'>добавить</a>
						";',
			'type'   => 'raw',
			'header' => 'Файлы'
		),		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
