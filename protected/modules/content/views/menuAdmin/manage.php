<?php 
$this->page_title = t('Меню сайта');

$this->widget('AdminGridView', array(
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
                    'label'    => t('ссылки'),
                    'imageUrl' => '/img/icons/links.gif',
                    'url'      => 'Yii::app()->createUrl("content/menuLinkAdmin/index", array("menu_id" => $data->id))'
                )
            ),
		),
	),
));
?>


