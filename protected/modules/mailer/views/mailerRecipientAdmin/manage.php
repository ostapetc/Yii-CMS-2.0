<script type="text/javascript">
    $(function()
    {
        $('#resend_rl_button').click(function()
        {
            var msg = "Не понял зачем письма с статусом 'Ожидает' должны повторно отправиться? они же и так в очереди и так на отправку.";
            alert(msg);
        });


        $('#refresh_rl_button').click(function()
        {   
            location.href = location.href;
        });
    });
</script>

<?php

$this->tabs = array(
    'добавить' => $this->createUrl('create')
);

$this->widget('AdminGrid', array(
	'id' => 'mailer-recipient-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name'   => 'user_id', 'value' => '$data->user->name', 'filter' => false),
        array('header' => 'Роль', 'value' => '$data->user->role->description'),
		array('name'   => 'status', 'value' => 'MailerRecipient::$statuses[$data->status]', 'filter' => false),
		array(
			'class'=>'CButtonColumn',
            'template' => ''
		),
	),
)); 

?>

<input type='button' class="submit mid" value="Обновить" id="refresh_rl_button">
