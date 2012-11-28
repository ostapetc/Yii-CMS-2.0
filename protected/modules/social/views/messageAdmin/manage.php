<?
$this->tabs = array(
    'добавить Сообщение' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
    'id'           => 'Message-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model
));
?>