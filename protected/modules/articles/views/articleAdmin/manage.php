<?php
$this->page_title = 'Управление материалами';

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
    "управление разделами" => $this->createUrl("articleSectionAdmin/manage"),
);

$this->widget('AdminGrid', array(
	'id'=>'articles-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
        array(
            'name'  => 'section_id',
            'value' => '$data->section->name'
        ),
		'date',
        array('name' => 'lang', 'value' => '$data->language->name'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
