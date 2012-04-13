<?
$this->tabs = array(
    'управление примерами'  => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('BootDetailView', array(
    'data' => $model
));
?>