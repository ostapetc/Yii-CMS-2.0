<?php $this->page_title = 'Редактирование блока страницы'; ?>

<?php
$this->tabs = array(
    "управление блоками" => $this->createUrl("manage")
);
?>

<?php echo $form; ?>