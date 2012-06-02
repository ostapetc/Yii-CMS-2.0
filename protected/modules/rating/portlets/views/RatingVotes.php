<?
$labels = array(
    'plus'   => t('поствить минус'),
    'minus'  => t('поставить плюс'),
    'denied' => t('ставить оценки могут только зарегистрированные пользователи')
);
?>

<?= $rating ?>

<? if (Yii::app()->user->isGuest): ?>

    <?=
    CHtml::image(
        '/img/icons/minus_na.png',
        $labels['denied'],
        array('title' => $labels['denied'])
    )
    ?>

    <?=
    CHtml::image(
        '/img/icons/plus_na.png',
        $labels['denied'],
        array('title' => $labels['denied'])
    )
    ?>

<? else: ?>

    <?=
    CHtml::image(
        '/img/icons/minus.png',
        $labels['minus'],
        array(
             'title'     => $labels['minus'],
             'value'     => '-1',
             'class'     => 'rating-img',
             'object_id' => $object_id,
             'model_id'  => $model_id
        )
    )
    ?>

    <?=
    CHtml::image(
        '/img/icons/plus.png',
        $labels['plus'],
        array(
             'title'     => $labels['plus'],
             'value'     => '1',
             'class'     => 'rating-img',
             'object_id' => $object_id,
             'model_id'  => $model_id
        )
    )
    ?>

<? endif ?>

