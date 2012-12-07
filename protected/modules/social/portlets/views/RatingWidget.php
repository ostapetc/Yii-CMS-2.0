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
   <?=
   CHtml::tag('span', array(
       'title'       => $labels['minus'],
       'class'       => "rating-vote minus glyphicon-thumbs-down",
       'data-value'  => '-1',
       'data-object' => $object_id,
       'data-model'  => $model_id,
       'data-role'   => 'user'
   ), '')
   ?>
   <?=
   CHtml::tag('span', array(
       'title'       => $labels['plus'],
       'class'       => "rating-vote plus glyphicon-thumbs-up",
       'data-value'  => '1',
       'data-object' => $object_id,
       'data-model'  => $model_id,
       'data-role'   => 'user'
   ), '')
   ?>
</span>

