<?
if ($topic)
{
    $this->page_title = t('Вопросы по тематике') . ': ' . $topic->name;
}

$this->tabs = array(
    'добавить вопрос' => $this->createUrl('create')
);
?>

<?
$this->widget('AdminGridView', array(
    'id'           => 'QuizQuestion-grid',
    'dataProvider' => $model->search(),
    'ajaxUpdate'   => false,
    'filter'       => $model
));
?>