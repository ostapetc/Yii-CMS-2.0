<?
$this->tabs = array(
    'управление Сообщениями'  => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('AdminDetailView', array(
    'data' => $model
));
?>