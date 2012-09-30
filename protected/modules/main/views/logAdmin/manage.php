<script type="text/javascript">
    $(function() {
        $('.show-in').click(function() {
            $(this).replaceWith($(this).attr('data-text'));
            return false;
        });
    });
</script>


<? $this->page_title = 'Просмотр логов'; ?>

<?
$this->widget('AdminGridView', array(
	'id' => 'grid',
	'dataProvider' => $model->search(),
    'filter' => $model,
	'columns' => array(
		array(
            'name'  => 'message',
            'type'  => 'raw',
            'value' => function($data)
            {
                $message = explode('in ', $data->message, 2);
                if (count($message) == 2)
                {
                    return $message[0] . "<a href='' class='show-in' data-text='{$message[1]}'>in</a>";
                }
                else
                {
                    return $data->message;
                }
            }
        ),
		'level',
        array('name' => 'logtime', 'filter' => false),
        array(
            'class'    => 'CButtonColumn',
            'template' => ''
        )
	),
));
?>