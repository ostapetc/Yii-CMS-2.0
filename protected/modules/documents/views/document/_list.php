<?php foreach ($documents as $document): ?>
	<?php 
	$url  = $this->url("/documents/{$document->id}");
	?>
	<div class="search_list">
	    <a href="<?php echo $url ?>" class="search_title"><?php echo $document->name; ?></a>
	    <div class="item_date"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $document->date_publish);  ?></div>
	    <a href="<?php echo $url ?>" class="more_info"><?php Yii::t('DocumentsModule.main', 'Подробнее'); ?></a>
	</div> 
<?php endforeach ?>
