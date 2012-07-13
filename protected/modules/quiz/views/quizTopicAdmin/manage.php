<?
$this->tabs = array(
    'добавить тематику' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
    'id'           => 'QuizTopic-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'class'    => 'CButtonColumn',
            'template' => '{add_answer} {view} {update} {delete}',
            'buttons'  => array(
                'add_answer' => array(
                    'imageUrl' => '/img/admin/question.png',
                    'url'      => 'Yii::app()->createUrl("/quiz/quizQuestionAdmin/create/topic_id/{$data->id}")',
                    'title'    => t('Добавить вариант ответа')
                )
            )
        )
    )
));
?>