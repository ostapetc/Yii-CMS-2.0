<?
$this->tabs = array(
    'добавить пример' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
    'id'           => 'Example-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model
));
?>