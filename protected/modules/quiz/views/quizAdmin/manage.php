<?
$this->tabs = array(
    'добавить Тест' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
    'id'           => 'Quiz-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model
));
?>
