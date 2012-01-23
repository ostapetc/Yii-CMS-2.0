<?php
$this->page_title = 'Добавление роли пользователя';

$this->tabs = array(
    "управление ролями" => $this->createUrl("create"),
);

echo $form;
?>