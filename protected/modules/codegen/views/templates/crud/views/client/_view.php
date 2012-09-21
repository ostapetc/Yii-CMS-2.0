<?
$model  = ActiveRecord::model($class);
$meta   = $model->meta();
$labels = $model->attributeLabels();
?>

<? foreach ($meta as $data): ?>
<?='<strong><?= $data->label(\'' . $data['Field'] . '\') ?></strong>: <?= $data->value(\'' . $data['Field'] . '\') ?>' . "\n"?> <br/>
<? endforeach ?>

<br/>
<a href="<?='<?= $data->url ?>'?>">просмотр</a>

<br/><hr/>
