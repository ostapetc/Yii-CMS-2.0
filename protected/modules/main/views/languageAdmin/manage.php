<?
$this->page_title = 'Управление';

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
                        return Yii::app()->language != $data->id;
                    }
                )
            )
		),
	),
)); 

