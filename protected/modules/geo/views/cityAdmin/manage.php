<?php
$this->page_title = "Управление городами";

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
);

$this->widget('AdminGrid', array(
	'id'=>'city-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update} {delete}'
		),
	),
)); 
?>
