<?
$labels = array(
    'plus'      => t('поствить минус'),
    'minus'     => t('поставить плюс'),
    'not_guest' => t('ставить оценки могут только зарегистрированные пользователи'),
    'not_owner' => t('нельзя ставить оценки самому себе'),
    'exists'    => t('вы уже поставили оценку')
);

$minus_na  = (int) $value < 0 ? 'glyphicon-na' : '';
$plus_na   = (int) $value > 0 ? 'glyphicon-na' : '';
?>

<span class="rating">
    <?= $rating ?>

    <? if (Yii::app()->user->isGuest): ?>
        <span title="<?= $labels['not_guest'] ?>" class="rating-vote minus-na glyphicon-thumbs-down"></span>
        <span title="<?= $labels['not_guest'] ?>" class="rating-vote plus-na glyphicon-thumbs-up"></span>
    <? else: ?>
        <? if ($user_id != Yii::app()->user->id): ?>
            <span title="<?= $labels['minus'] ?>" class="rating-vote minus glyphicon-thumbs-down <?= $minus_na ?>" value="-1" object_id="<?= $object_id ?>" model_id="<?= $model_id ?>"></span>
            <span title="<?= $labels['plus'] ?>" class="rating-vote plus glyphicon-thumbs-up <?= $plus_na ?>" value="1" object_id="<?= $object_id ?>" model_id="<?= $model_id ?>"></span>
        <? else: ?>
            <span title="<?= $labels['not_owner'] ?>" class="rating-vote minus glyphicon-thumbs-down glyphicon-na"></span>
            <span title="<?= $labels['not_owner'] ?>" class="rating-vote plus glyphicon-thumbs-up glyphicon-na"></span>
        <? endif ?>
    <? endif ?>
</span>

