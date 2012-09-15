<?
$cs = Yii::app()->clientScript->registerCssFile('/css/site/user.css');

switch (true)
{
    case $model->rating == 0:
        $rating_class = '';
        break;

    case $model->rating > 0:
        $rating_class = 'label-success';
        break;

    case $model->rating < 0:
        $rating_class = 'label-important';
        break;
}
?>

<div class='profile-head'>
    <?= $model->getPhotoHtml(User::PHOTO_SIZE_BIG); ?>
    <h1><?= $model->name ?></h1>
    <div class="label <?= $rating_class ?>">рейтинг <?= $model->rating ?></div>
</div>

<br clear="all" />

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