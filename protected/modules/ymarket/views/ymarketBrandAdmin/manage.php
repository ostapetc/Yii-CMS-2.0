<?php

$this->widget('GridView', array(
	'id' => 'ymarket-brand-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		'name'
	),
)); 

