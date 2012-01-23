<?php
$this->page_title = 'Добавление вопроса';

$this->tabs = array(
    "управление вопросами" => $this->createUrl("manage"),
);

echo $form;
?>