<script src="http://localhost:8888/socket.io/socket.io.js"></script>

<?
$cs = Yii::app()->clientScript;
$cs->registerCssFile('/css/site/messages.css');
$cs->registerScriptFile(
    Yii::app()->assetManager->publish(MODULES_PATH . 'social' . DS . 'components' . DS . 'nodejs' . DS . 'MessageIndexClient.js')
);

$this->page_title = t('Сообщения') . ' &rarr; ' . $to_user->name;

$this->widget('BootListView', array(
    'id'               => 'Message-listView',
    'dataProvider'     => $data_provider,
    'itemView'         => '_view',
    'emptyText'        => t('Сообщения не найдены'),
    'itemsCssClass'    => 'messages-list',
    'summaryText'      => false,
    'enablePagination' => false
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
                <?= CHtml::textArea('Message[text]', '') ?>
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
