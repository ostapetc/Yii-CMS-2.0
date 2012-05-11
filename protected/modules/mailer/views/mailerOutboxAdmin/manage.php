<?
//$this->tabs = array(
//    'добавить исходящее письмо' => $this->createUrl('create')
//);

$this->widget('AdminGridView', array(
	'id'           => 'outbox-email-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
	'columns'      => array(
		array('name' => 'email'),
		array('name' => 'subject'),
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

