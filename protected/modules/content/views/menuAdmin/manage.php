<?php 
$this->page_title = 'Меню сайта'; 

$this->tabs = array(
	'добавить меню' => $this->createUrl('create')
);

$this->widget('AdminGrid', array(
	'id' => 'menu-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns'=>array(
		'name',
		array('name' => 'is_visible', 'value' => '$data->is_visible ? \'Да\' : \'Нет\''),
		array(
			'class'    => 'CButtonColumn',
            'template' => '{links} {update} {delete}',
            'buttons'  => array(
                'links' => array(
                    'label'    => 'ссылки',
                    'imageUrl' => '/images/icons/links.gif',
                    'url'      => 'Yii::app()->createUrl("content/menuLinkAdmin/index", array("menu_id" => $data->id))'
                )
            ),
		),
	),
));
?>

