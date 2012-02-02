<div class="hero-unit">
    <h1><?php echo $page->title ?></h1>

    <p><?php echo $page->content ?></p>

    <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
</div>
<?php $this->widget('news.portlets.LastNews') ?>
