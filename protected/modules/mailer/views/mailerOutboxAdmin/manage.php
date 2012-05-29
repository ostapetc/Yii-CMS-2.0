<?
$this->tabs = array(
    'отправить письмо' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id'           => 'outbox-email-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
	'columns'      => array(
		array('name' => 'email'),
		array(
            'name'   => 'template_id',
            'value'  => '$data->template->name',
            'filter' => CHtml::listData(MailerTemplate::model()->findAll(), 'id', 'name')
        ),
        array(
            'name'   => 'status',
            'value'  => '$data->status_caption',
            'filter' => MailerOutbox::$status_list
        ),
        array('name' => 'log'),
		array(
            'name'   => 'date_create',
            'filter' => false
        ),
		array(
            'name'   => 'date_send',
            'filter' => false
        ),
		array(
			'class'    => 'CButtonColumn',
            'template' => '{view}'
		),
	),
)); 

