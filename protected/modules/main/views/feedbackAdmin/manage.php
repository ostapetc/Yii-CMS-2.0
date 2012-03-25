<? $this->page_title = 'Управление сообщениями'; ?>

<?
$this->widget('AdminGridView', array(
	'id'=>'feedback-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'first_name',
        'last_name',
        'patronymic',
        'company',
        'position',
        'phone',
		'email',
		'comment',
		'date_create',
		array(
			'class'    => 'CButtonColumn',
			'template' => '{delete}' 
		),
	),
)); 
?>
