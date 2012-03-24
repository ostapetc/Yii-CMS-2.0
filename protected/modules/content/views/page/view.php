<?php $this->page_title = $page->title; ?>
<br/>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <?php echo $this->msg(t(Yii::app()->user->getFlash('success')), 'success'); ?>
<?php endif ?>


<?php if ($page->widget): ?>
    <?php
    $short_text = trim(strip_tags($page->short_text));
    ?>
    <?php if (!empty($short_text)): ?>
        <?php echo $page->short_text; ?>
    <?php endif ?>
<?php endif ?>

<?php if ($page->widget): ?>
    <?php $this->widget($page->widget); ?>
<?php endif ?>

<?php echo $page->content; ?>

