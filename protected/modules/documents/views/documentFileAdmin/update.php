<?php $this->page_title = "Редактирование файла мероприятия";

$this->tabs = array(
    "управление файлами" => $this->createUrl("manage", array("document_id" => $form->model->document->id)),
);
?>

<h3><?php echo $form->model->document->name; ?></h3>

<?php echo $form; ?>
