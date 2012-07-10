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
<br clear="all" />

<table class="table table-striped profile-table">
    <tbody>
        <tr>
            <td><?= $model->label('about_self') ?></td>
            <td>
                <?= $model->about_self ? $model->about_self : t('Пока ничего не известно...') ?>
            </td>
        </tr>
        <tr>
            <td><?= $model->label('gender'); ?></td>
            <td><?= $model->value('gender') ?: t('не указан'); ?></td>
        </tr>
        <tr>
            <td><?= $model->label('email') ?></td>
            <td><?= $model->email ?></td>
        </tr>
        <tr>
            <td><?= $model->label('birthdate') ?></td>
            <td>
                <?= $model->value('birthdate') ?>
            </td>
        </tr>
        <tr>
            <td><?= $model->label('date_create'); ?></td>
            <td><?= $model->value('date_create'); ?></td>
        </tr>
    </tbody>
</table>

<? if (Yii::app()->user->id == $model->id): ?>
    <?= CHtml::link(t('Редактировать личные данные'), array("/user/update/$model->id"), array('class' => 'update-link')); ?>
<? endif ?>
