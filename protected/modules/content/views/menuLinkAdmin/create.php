<?php
$this->tabs = array(
    "управление ссылками" => $this->createUrl("index", array("menu_id" => $model->menu->id))
);

echo $form;
