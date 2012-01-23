<?php
$this->page_title = 'Управление статьями';

$this->tabs = array(
    "добавить статью" => $this->createUrl("create")
);

$this->widget('AdminGrid', array(
	'id'=>'press-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		array('name' => 'state', 'value' => 'Glossary::$states[$data->state]'),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}'
		),
	),
)); 
?>
