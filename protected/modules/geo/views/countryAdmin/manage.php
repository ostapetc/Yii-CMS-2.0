<?php
$this->page_title = "Управление странами";

$this->tabs = array(
    "добавить" => $this->createUrl("create"),
);

$this->widget('AdminGrid', array(
	'id'=>'country-grid',
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
