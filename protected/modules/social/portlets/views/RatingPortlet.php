<?
$labels = array(
    'plus'      => t('поствить минус'),
    'minus'     => t('поставить плюс'),
    'not_guest' => t('ставить оценки могут только зарегистрированные пользователи'),
    'not_owner' => t('нельзя ставить оценки самому себе'),
    'exists'    => t('вы уже поставили оценку')
);
?>

<div class="rating">
    <?= $rating ?>

    <? if (Yii::app()->user->isGuest): ?>
        <div title="<?= $labels['not_guest'] ?>" class="rating-vote minus-na"></div>
        <div title="<?= $labels['not_guest'] ?>" class="rating-vote plus-na"></div>
    <? elseif ($exists): ?>
        <div title="<?= $labels['exists'] ?>" class="rating-vote minus-na"></div>
        <div title="<?= $labels['exists'] ?>" class="rating-vote plus-na"></div>
    <? else: ?>
        <? if ($user_id != Yii::app()->user->id): ?>
            <div title="<?= $labels['minus'] ?>" class="rating-vote minus" value="-1" object_id="<?= $object_id ?>" model_id="<?= $model_id ?>"></div>
            <div title="<?= $labels['plus'] ?>" class="rating-vote plus" value="1" object_id="<?= $object_id ?>" model_id="<?= $model_id ?>"></div>
        <? else: ?>
            <div title="<?= $labels['not_owner'] ?>" class="rating-vote minus-na"></div>
            <div title="<?= $labels['not_owner'] ?>" class="rating-vote plus-na"></div>
        <? endif ?>
    <? endif ?>
</div>

