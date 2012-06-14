<?php if($banners): ?>
	<div class="banner" id="big_banners">
		<div class="images">
			<?php foreach($banners as $banner): ?>
				<div class="items">
					<?php
					$img = ImageHelper::thumb(Banner::IMAGES_DIR, $banner -> image, 1000, 240, true, "alt='{$banner -> name}' title='{$banner -> name}'");
					if(($url = $banner -> getHref()))
					{
						$url = Yii::app()->controller-> createRedirectUrl($url, $banner -> id, 'banners');
						echo CHtml::link($img, $url, array(
							'title' => $banner -> name,
						));
					}
					else
					{
						echo $img;
					}
					?>
				</div>
			<?php endforeach ?>
		</div>

		<?php if(count($banners) > 1): ?>
			<div class="pager">
				<div class="left"></div>
				<div class="navigation">
					<?php for($i = 1; $i <= count($banners); $i ++ ): ?>
						<?php $n = $i; ?>
						<div><a href="" onclick="return false;"><?php echo $n ++; ?></a></div>

						<?php if($n != count($banners) + 1): ?>
							<span>|</span>
						<?php endif ?>

					<?php endfor ?>
				</div>
				<div class="right"></div>
			</div>
		<?php endif ?>

		<div class="clear"></div>
	</div>
<?php endif; ?>