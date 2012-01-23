<?php
$this->page_title = 'Редактирование пользователя' . $form->model->name;

$this->tabs = array(
    "управление пользователями" => $this->createUrl("manage"),
);

echo $form;
?>