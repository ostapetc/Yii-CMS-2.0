<?php
$this->page_title = 'Редактирование ';

$this->tabs = array(
    "управление мероприятиями" => $this->createUrl("manage"),
    "просмотр мероприятия"     => $this->createUrl("view", array("id" => $form->model->id))
);

echo $form;
?>