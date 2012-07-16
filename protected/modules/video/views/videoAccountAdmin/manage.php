<?
$this->tabs = array(
    'Добавить аккаунт' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id'           => 'email-template-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model
));
?>




