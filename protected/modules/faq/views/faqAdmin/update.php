<?php
$this->page_title = 'Редактирование вопроса';

$this->tabs = array(
    "управление вопросами" => $this->createUrl("manage"),
);

echo $form;
?>