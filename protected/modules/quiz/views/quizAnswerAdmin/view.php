<?
$this->tabs = array(
    'добавить еще ответ'   => $this->createUrl('/quiz/quizAnswerAdmin/create/question_id/' . $model->question_id),
    'управление ответами'  => $this->createUrl('manage'),
    'редактировать'        => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('AdminDetailView', array(
    'data' => $model
));
?>