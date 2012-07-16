<?
$this->tabs = array(
    'управление шаблонами' => $this->createUrl('manage'),
    'редактировать'        => $this->createUrl('update', array('id' => $model->id)),
);

$this->widget('AdminDetailView', array(
	'data'       => $model,
	'attributes' => array(
		array(
            'name' => 'name'
        ),
		array(
            'name'  => 'subject',
            'value' => $model->constructSubject(User::model()->find()),
            'type'  => 'raw'
        ),
        array(
            'name'  => 'date_create',
            'value' => date('d.m.Y h:i', strtotime($model->date_create))
        )
	),
));
?>

<br/>
<hr/>

<iframe frameborder="0" allowtransparency="true" width="800" height="1200px" scrolling="auto" src="<?= $this->createUrl("/mailer/mailerTemplateAdmin/bodyView", array("id" => $model->id))?>"></iframe>




