1. public function behaviors()
	{
		return array(
			'sortable'=>array(
				'class'=>'ext.sortable.ManyManySortableBehavior',
				'relation'=>'categories',
				'map_field'=>'order',
			),
		);
	}

2.
<?php $this->widget('GridView', array(
	'id'=>'test-product-grid',
	'dataProvider'=>$model->search($cat_id),
	'many_many_sortable'=>true,
	'cat_id'=>$cat_id,
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>