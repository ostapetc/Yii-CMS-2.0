<?
Yii::app()->clientScript->registerScriptFile('/js/social/messages.js');

$this->page_title = t('Сообщения') . ' &rarr; ' . $to_user->name;

$this->widget('BootListView', array(
    'id'           => 'Message-listView',
    'dataProvider' => $data_provider,
    'itemView'     => '_view',
    'emptyText'    => t('Сообщения не найдены')
));
?>

<br/>

<div class="well">
    <?= CHtml::beginForm(Message::model()->getCreateUrl(), 'post', array('class' => 'margin-null', 'id' => 'message-form')); ?>
    <table>
        <tr valign="top">
            <td style="padding-right: 10px;">
                <?= Yii::app()->user->model->getPhotoHtml(User::PHOTO_SIZE_BIG) ?>
            </td>
            <td>
                <?= CHtml::hiddenField('Message[to_user_id]', $to_user->id) ?>
                <?= CHtml::textArea('Message[text]', '', array('style' => 'width: 470px')) ?>
            </td>
            <td style="padding-left: 10px;">
                <?= $to_user->getPhotoHtml(User::PHOTO_SIZE_BIG) ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <?= CHtml::submitButton('Отправить', array('class' => 'btn btn-primary btn-small')) ?>
            </td>
            <td></td>
        </tr>
    </table>
    <?= CHtml::endForm(); ?>
</div>
