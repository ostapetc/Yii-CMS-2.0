<?
$this->tabs = [
    'редактировать'   => $this->createUrl('update', ['id' => $model->id]),
    'список разделов' => $this->createUrl('manage')
];

$this->widget('BootDetailView', [
	'data'=>$model,
	'attributes'=>[
        'name',
		[
            'name'  => 'parent_id',
            'value' => $model->parent ? $model->parent->name : null
        ],
		[
            'name'  => 'date_create',
            'value' => date('d.m.Y h:i', strtotime($model->date_create))
        ],
    ],
]);
