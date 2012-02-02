<?php $this->page_title = 'Редактирование блока страницы'; ?>

<?php
$this->tabs = array(
    $this->t('admin', 'manage')  => $this->createUrl("manage")
);
?>

<?php echo $form; ?>