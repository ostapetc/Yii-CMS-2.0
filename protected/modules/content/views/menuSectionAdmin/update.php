<?php
$this->page_title = $model->menu->name . " :: редактирование раздела";

$this->tabs = array(
    "управление разделами" => $this->createUrl($back, array("menu_id" => $model->menu->id))
);

echo $form
?>
