<?
$model  = ActiveRecord::model($class);
$meta   = $model->meta();
$labels = $model->attributeLabels();
?>

<? foreach ($meta as $data): ?>
<?='<?= $data->' . $data['Field'] . '_label?>: <?= $data->' . $data['Field'] . '?>' . "\n"?> <br/>
<? endforeach ?>

<br/>
<a href="<?='<?= $data->href ?>'?>">просмотр</a>

<br/><hr/>
