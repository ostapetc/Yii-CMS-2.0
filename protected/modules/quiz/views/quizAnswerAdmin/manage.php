<?
$this->tabs = array(
    'добавить варианта ответа' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
    'id'           => 'QuizAnswer-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model
));
?>