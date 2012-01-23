<?php $this->page_title = 'Добавление материала'; ?>

<?php
$this->tabs = array(
    "управление материалами" => $this->createUrl("manage"),
    "управление разделами" => $this->createUrl("manage"),
);
?>

<?php echo $form; ?>