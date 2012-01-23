<?php

$this->tabs = array(
    "Добавить" => $this->createUrl("create")
);

$this->widget('AdminGrid', array(
	'id'=>'action-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'place',
		array(
            'name'  => 'image',
            'value' => 'ImageHelper::thumb(Action::IMG_DIR, $data->image, Action::IMG_SMALL_WIDTH)',
            'type'  => 'raw'
        ),
		'date',
		'date_create',
		array('name' => 'lang', 'value' => '$data->language->name'),
		array(
			'name'   => 'files',
			'value'  => '"<a href=\'/actions/actionFileAdmin/manage/action_id/$data->id\'>просмотр</a>";',
			'type'   => 'raw',
			'header' => 'Файлы'
		),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 
?>
