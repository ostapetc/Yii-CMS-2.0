<?
$this->tabs = array(
    'добавить вариант ответа' => $this->createUrl('/quiz/quizAnswerAdmin/create/question_id/' . $model->id),
    'добавить вопрос'         => $this->createUrl('/quiz/quizQuestionAdmin/create/topic_id/' . $model->topic_id),
    'управление вопросами'    => $this->createUrl('manage'),
    'редактировать'           => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('AdminDetailView', array(
    'data' => $model
));
?>

<br/>

<? if ($model->answers): ?>
    <h4>Варианты ответов</h4> <br/>
    <table class="table table-striped">
        <tr>
            <th><?= t('Ответ') ?></th>
            <th style="text-align: center"><?= t('Верный') ?></th>
            <th style="text-align: center"><?= t('Кол-во баллов') ?></th>
            <th width="50"></th>
        </tr>
        <? foreach ($model->answers as $answer): ?>
            <tr>
                <td><?= $answer->value('text') ?></td>
                <td align="center" style="text-align: center"><?= $answer->value('is_right') ?></td>
                <td align="center" style="text-align: center"><?= $answer->value('points') ?></td>
                <td>
                    <?=
                    CHtml::link(
                        CHtml::image('/img/admin/view.png'),
                        Yii::app()->createUrl('/quiz/quizAnswerAdmin/view/id/' . $answer->id)
                    )
                    ?>
                    &nbsp;
                    <?=
                    CHtml::link(
                        CHtml::image('/img/admin/update.png'),
                        Yii::app()->createUrl('/quiz/quizAnswerAdmin/update/id/' . $answer->id)
                    )
                    ?>
                </td>
            </tr>
        <? endforeach ?>
    </table>
<? endif ?>