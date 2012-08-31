<?
$this->tabs = array(
    'управление аккаунтами' => $this->createUrl('manage'),
    'редактировать'         => $this->createUrl('update', array('id' => $model->id)),
);

$this->widget('AdminDetailView', array(
	'data' => $model
));
?>

