<?php $this->page_title = $action->name; ?>


<?php 
echo ImageHelper::thumb(
	Action::IMG_DIR, 
	$action->image, 
	Action::IMG_BIG_WIDTH, 
	null, 
	false,
	"border='0' class='detail_img'"
);
?>


<b><?php echo Yii::t('ActionsModule.main', 'Дата проведения'); ?>:</b>
<?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $action->date);  ?>

<br/>

<b><?php echo Yii::t('ActionsModule.main', 'Место проведения'); ?>:</b>
<?php echo $action->place;  ?>

<br/>

<b><?php echo Yii::t('ActionsModule.main', 'Описание'); ?>:</b> <br/>
<?php echo $action->desc;  ?>



<?php if ($action->files): ?>
	<div style="margin-top:30px;margin-bottom:10px;font-weight:bold"><?php echo Yii::t('ActionsModule.main', 'Файлы для скачивания'); ?>:</div>

	<?php foreach ($action->files as $file): ?>
		<a href='/<?php echo ActionFile::FILES_DIR . "/" . $file->file ?>' class='link_13'><?php echo $file->file ?></a> <br/>
	<?php endforeach ?>
<?php endif ?>



