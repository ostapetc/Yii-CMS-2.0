<?php foreach ($actions as $action): ?>
		<?php 
		$url  = $this->url("/action/{$action->id}");
		$img  = ImageHelper::thumb(Action::IMG_DIR, $action->image, Action::IMG_MID_WIDTH, Action::IMG_MID_HEIGHT, true);
			
		if ($img) 
		{
		    $desc =	Text::cut($action->desc, 300, ' ', '...');   
		}
		else 
		{
		    $desc =	Text::cut($action->desc, 400, ' ', '...');
		}
		
		?>
		<div class="search_list">
		    <a href="<?php echo $url; ?>" style="float:left;margin-right:12px">
		        <?php echo $img; ?>
		    </a>
		    <a href="<?php echo $url ?>" class="search_title"><?php echo $action->name; ?></a>
		    <div class="item_date"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $action->date);  ?></div>

		    <p><b><?php echo Yii::t('ActionsModule.main', 'Место проведения'); ?>:</b> <?php echo $action->place; ?></p>
			<p><?php echo $desc; ?></p>
		</div> 
<?php endforeach ?>
