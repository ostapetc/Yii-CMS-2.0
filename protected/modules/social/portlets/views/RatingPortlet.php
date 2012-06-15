<?
$labels = array(
    'plus'   => t('поствить минус'),
    'minus'  => t('поставить плюс'),
    'denied' => t('ставить оценки могут только зарегистрированные пользователи')
);
?>

<div class="rating">
    <?= $rating ?>

    <? if (Yii::app()->user->isGuest): ?>
        <div title="<?= $labels['denied'] ?>" class="rating-vote minus-na"></div>
        <div title="<?= $labels['denied'] ?>" class="rating-vote plus-na"></div>
    <? else: ?>
        <div title="<?= $labels['minus'] ?>" class="rating-vote minus" value="-1" object_id="<?= $object_id ?>" model_id="<?= $model_id ?>"></div>
        <div title="<?= $labels['plus'] ?>" class="rating-vote plus" value="1" object_id="<?= $object_id ?>" model_id="<?= $model_id ?>"></div>
    <? endif ?>
</div>

