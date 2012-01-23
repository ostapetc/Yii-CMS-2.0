<?php
$this->page_title = 'Управление разделами FAQ';

$this->tabs = array(
    "добавить раздел" => $this->createUrl("create")
);

$this->widget('AdminGrid', array(
	'id'=>'faq-section-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		array('name' => 'is_published', 'value' => '$data->is_published ? \'Да\':\'Нет\''),
        array('name' => 'lang', 'value' => '$data->language->name'),		
		array(
			'class'=>'CButtonColumn',
			'template' => '{update} {delete}'
		),
	),
)); 
?>
    
