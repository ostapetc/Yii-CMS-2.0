<?php

if ($is_big == 1)
{
    $this->page_title = 'Горизонтальные баннеры';
}
else
{
    $this->page_title = 'Вертикальные баннеры';
}

$this->tabs = array(
    'добавить вертикальный баннер'   => $this->createUrl('create'),
);

$this->widget('AdminGridView', array(
	'id' => 'banner-grid',
	'dataProvider' => $model->search(),
	'filter'   => $model,
    'sortable' =>true,
	'columns' => array(
		array('name' => 'name'),
		array('name' => 'url', 'value' => '$data->href'),
		array('name' => 'is_active', 'value' => '$data->is_active ? "Да" : "Нет"'),
		array('name' => 'date_start'),
		array('name' => 'date_end'),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 

