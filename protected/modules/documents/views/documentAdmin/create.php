<?php
$this->page_title = 'Добавление документа';

$this->tabs = array(
    "управление документами" => $this->createUrl("manage"),
);

echo $form;
?>