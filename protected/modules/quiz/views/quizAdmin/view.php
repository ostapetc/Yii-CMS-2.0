<?
$this->tabs = array(
    'управление Тестами'  => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('AdminDetailView', array(
    'data' => $model
));
?>