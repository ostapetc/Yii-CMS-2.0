<?
$this->tabs = array(
    'добавить вопрос'       => $this->createUrl('/quiz/quizQuestionAdmin/create/topic_id/' . $model->id),
    'управление тематиками' => $this->createUrl('manage'),
    'редактировать'         => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('AdminDetailView', array(
    'data' => $model
));
?>