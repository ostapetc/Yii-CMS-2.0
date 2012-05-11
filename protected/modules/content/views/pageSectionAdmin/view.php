<?
$this->tabs = array(
    'редактировать'   => $this->createUrl('update', array('id' => $model->id)),
    'список разделов' => $this->createUrl('manage')
);

$this->widget('BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'name',
		array(
            'name'  => 'parent_id',
            'value' => $model->parent ? $model->parent->name : null
        ),
		array(
            'name'  => 'date_create',
            'value' => date('d.m.Y h:i', strtotime($model->date_create))
        ),
	),
));
