<?php
$this->page_title = 'Управление';

$config = AppManager::getConfig();

$this->widget('AdminGridView', array(
	'id' => 'language-grid',
	'dataProvider' => $model->search(),
	'filter'   => $model,
	'columns'  => array(
	    'id',
		'name',
		array(
			'class'    => 'CButtonColumn',
			'template' => '{update}{delete}',
            'buttons'  => array(
                'delete' => array(
                    'visible' => function($i, $data) {
                        $config = AppManager::getConfig();
                        return $config["language"] != $data->id;
                    }
                )
            )
		),
	),
)); 

