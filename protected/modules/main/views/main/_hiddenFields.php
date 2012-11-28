<?
$fields = array(
    'current_controller' => Yii::app()->controller->id,
    'current_module'     => Yii::app()->controller->action->id,
    'current_action'     => Yii::app()->controller->module->id
);
?>

<? foreach ($fields as $name  => $value): ?>
    <?= CHtml::hiddenField($name, $value, array('id' => $name)) ?>
<? endforeach ?>