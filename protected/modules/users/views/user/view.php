<?
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/social/friends.js');

$users_status = Friend::getUsersStatus($model->id, Yii::app()->user->id);
?>

<div class='profile-head'>
    <?= $model->getPhotoHtml(User::PHOTO_SIZE_BIG); ?>
    <h1><?= $model->name ?></h1>
    <div class="label <?= $model->rating_css_class ?>">рейтинг <?= $model->rating ?></div>
</div>

<br clear="all" />

<div style="clear:left;margin-top: 10px !important;margin-bottom: 5px;">
    <? if (!Yii::app()->user->isGuest && (Yii::app()->user->id != $model->id)): ?>
        <?=
        CHtml::link('Отправить сообщение', array('/social/message/index', 'to_user_id' => $model->id), array('class' => 'btn btn-mini btn-primary'));
        ?>
    <? endif ?>

    <? if ($users_status == Friend::USERS_STATUS_FRIENDS): ?>
        <?=
        CHtml::link(t('Удалить из друзей'), '', array('class' => 'btn btn-mini btn-danger delete-friend-btn', 'friend_id' => $model->id));
        ?>
    <? elseif ($users_status == Friend::USERS_STATUS_NOT_FRIENDS): ?>
        <?=
        CHtml::link(t('Добавить в друзья'), '/', array('class' => 'btn btn-mini btn-success'));
        ?>
    <? endif ?>
</div>

<table class="table table-striped profile-table">
    <tbody>
        <tr>
            <td><?= $model->label('about_self') ?></td>
            <td>
                <? if ($model->about_self): ?>
                    <?= $model->about_self ?>
                <? else: ?>
                    <span class="light-grey"><?= t('не указано') ?></span>
                <? endif ?>
            </td>
        </tr>
        <tr>
            <td><?= $model->label('gender'); ?></td>
            <td>
                <? if ($gender = $model->value('gender')): ?>
                    <?= $gender ?>
                <? else: ?>
                    <span class="light-grey"><?= t('не указан') ?></span>
                <? endif ?>
            </td>
        </tr>
        <tr>
            <td><?= $model->label('email') ?></td>
            <td><?= $model->email ?></td>
        </tr>
        <tr>
            <td><?= $model->label('birthdate') ?></td>
            <td>
                <?= $model->value('birthdate') ?: t('не указана'); ?>
            </td>
        </tr>
        <tr>
            <td><?= $model->label('date_create'); ?></td>
            <td><?= $model->value('date_create'); ?></td>
        </tr>
    </tbody>
</table>