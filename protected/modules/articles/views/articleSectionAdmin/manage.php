<?php
$this->page_title = 'Управление разделами';

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
    "управление материалами" => $this->createUrl("articleAdmin/manage"),
);

$this->widget('AdminGrid', array(
	'id'=>'article-section-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		array('name' => 'parent_id', 'value' => '$data->parent ? $data->parent->name : null'),
		array('name' => 'in_sidebar', 'value' => '$data->in_sidebar ? "Да" : "Нет"'),
		'date_create',
        array('name' => 'lang', 'value' => '$data->language->name'),		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
