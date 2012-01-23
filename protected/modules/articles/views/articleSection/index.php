<?php $this->page_title = Yii::t('ArticlesModule.main', 'Разделы баз знаний'); ?>

<style type="text/css">
	#ul_sections {
		margin-left:20px;
		margin-top:20px
	}	

	#ul_sections li{
		padding-top:5px;
		padding-bottom: 5px;		
	}
</style>

<ul id="ul_sections">
    <?php foreach ($sections as $section): ?>
        <li>
            <a href="<?php echo $this->url("/articles/article/index/section_id/{$section->id}") ?>">
                <?php echo $section->name; ?>
            </a>
			<?php if ($section->childs): ?>
				<ul style='margin-left:10px'>
					<?php foreach ($section->childs as $child): ?>						
						<li>
							<a href="<?php echo $this->url("/articles/article/index/section_id/{$child->id}"); ?>">
                                <?php echo $child->name; ?>
                            </a>
						</li>
					<?php endforeach ?>		
				</ul>	
			<?php endif ?>
        </li>
    <?php endforeach ?>
</ul>
