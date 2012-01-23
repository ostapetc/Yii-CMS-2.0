<?php 
$this->page_title = 'Добавление операции'; 

$this->tabs = array(
    'Операции' => $this->createUrl('manage'),
);
?>

<?php if ($modules): ?>
    <?php echo $form; ?>
<?php else: ?>
    <?php echo $this->msg("Все задачи уже добавлены!", "info"); ?>
<?php endif ?>
