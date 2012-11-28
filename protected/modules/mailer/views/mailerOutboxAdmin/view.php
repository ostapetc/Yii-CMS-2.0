<?

$this->tabs = array(
    'исходящие письма' => $this->createUrl('manage'),

);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array(
            'name' => 'email'
        ),
        array(
            'name'  => 'user_id',
            'value' => $model->user->name
        ),
        array(
            'name'  => 'template_id',
            'value' => $model->template->name
        ),
		array(
            'name' => 'subject'
        ),
        array(
            'name'  => 'date_create',
            'value' => date('d.m.Y H:i', strtotime($model->date_create))
        ),
      	array(
              'name'  => 'date_send',
              'value' => $model->date_send ? date('d.m.Y H:i', strtotime($model->date_send)) : null
        ),
        array(
            'name'  => 'status',
            'value' => $model->status_caption
        ),
        array('name' => 'log'),
	),
));
?>

<iframe frameborder="0" allowtransparency="true" width="800" height="1200px" scrolling="auto" src="<?= $this->createUrl("/mailer/mailerOutboxAdmin/bodyView", array("id" => $model->id))?>"></iframe>


