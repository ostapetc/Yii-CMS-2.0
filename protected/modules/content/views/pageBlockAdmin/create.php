<?php $this->page_title = 'Добавление блока страницы'; ?>

<?php
$this->tabs = array(
    "управление блоками" => $this->createUrl("manage")
);
?>

<?php echo $form; ?>