<style type="text/css">
    .button-column {
        width: 100px !important;
    }
</style>

<?php
$this->page_title = 'Меню сайта'; 

$this->tabs = array(
	'добавить меню' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id' => 'menu-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'name',
		array(
            'class' => 'gridColumns.PublishedColumn',
            'name'   => 'is_published',
        ),
		array(
			'class'    => 'CButtonColumn',
            'template' => '{manage} {update}',
            'buttons'  => array(
                'manage' => array(
                    'label'    => 'управление разделами',
                    'imageUrl' => $this->module->assetsUrl() . '/img/manage.png',
                    'url'      => 'Yii::app()->createUrl("content/MenuSectionAdmin/manage", array("menu_id" => $data->id))'
                ),
//                'links' => array(
//                    'label'    => 'ссылки',
//                    'imageUrl' => $this->module->assetsUrl() . '/img/tree.png',
//                    'url'      => 'Yii::app()->createUrl("content/MenuSectionAdmin/index", array("menu_id" => $data->id))'
//                )
            ),
		),
	),
));
?>

