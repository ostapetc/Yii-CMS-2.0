<?
$this->page_title = 'Управление пользователями';

$this->widget('AdminGridView', array(
	'id' => 'user-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(),
));
?>
