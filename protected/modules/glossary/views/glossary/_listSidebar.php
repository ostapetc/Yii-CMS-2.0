<?php foreach ($press_list as $item): ?>
    <?php $url  = $this->url("/press/{$item->id}");?>
    <div class="right_link"><?php echo CHtml::link($item->title, $url, array('data-ajax'=>'true')) ?></div>
<?php endforeach ?>
