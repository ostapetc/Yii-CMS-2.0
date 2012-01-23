<?php $this->page_title = $document->name; ?>

<div class="item_date">
    <?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $document->date_publish);  ?>
</div>

<br clear="all"/>

<?php echo $document->content; ?>

<br clear='all' />

<?php if ($document->files): ?>
	<div style="margin-top:30px;margin-bottom:10px;font-weight:bold"><?php Yii::t('DocumentsModule.main', 'Файлы для скачивания'); ?>:</div>

	<?php foreach ($document->files as $file): ?>
		<a href='/<?php echo DocumentFile::FILES_DIR . "/" . $file->file ?>' class='link_13'><?php echo $file->title ?></a> <br/>
	<?php endforeach ?>
<?php endif ?>

