<?php $this->page_title = 'Добавление блока страницы'; ?>

<?php
$this->tabs = array(
    $this->t('admin', 'manage')  => $this->createUrl("manage")
);
?>

<?php echo $form; ?>