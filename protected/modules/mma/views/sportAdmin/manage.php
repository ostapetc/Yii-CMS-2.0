<?
$this->tabs = array(
    'добавить вид спорта' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
    'id'           => 'Sport-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model
));
?>