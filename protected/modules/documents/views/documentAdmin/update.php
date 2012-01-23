<?php
$this->page_title = 'Редактирование документа';

$this->tabs = array(
    "управление документами" => $this->createUrl("manage"),
);

echo $form;
?>