<?
$this->page_title = $model->menu->name . " :: редактирование раздела";

$this->tabs = [
    "управление разделами" => $this->createUrl($back, ["menu_id" => $model->menu->id])
];

echo $form;
