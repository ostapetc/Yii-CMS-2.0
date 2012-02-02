<?php 
$this->page_title = 'Добавление операции';
?>

<?php if ($modules): ?>
    <?php echo $form; ?>
<?php else: ?>
    <?php echo $this->msg("Все задачи уже добавлены!", "info"); ?>
<?php endif ?>
