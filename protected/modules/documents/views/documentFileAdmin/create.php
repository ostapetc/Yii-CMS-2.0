<?php
$this->page_title = "Добавление файла документа ";

$this->tabs = array(
    "управление файлами" => $this->createUrl("manage", array("document_id" => $document->id)),
);
?>

<h3><?php echo $document->name; ?></h3>

<?php echo $form; ?>
