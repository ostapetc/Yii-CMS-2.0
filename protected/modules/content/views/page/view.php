<?php $this->page_title = $page->title; ?>
<br/>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <?php echo $this->msg(t(Yii::app()->user->getFlash('success')), 'success'); ?>
<?php endif ?>

<?php echo $page->content; ?>

