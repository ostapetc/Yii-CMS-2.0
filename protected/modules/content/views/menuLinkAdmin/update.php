<?php
Yii::app()->getClientScript()->registerScriptFile('/js/modules/content/menuLinkForm.js');

$this->page_title = $model->menu->name . " :: редактирование ссылки";

$this->tabs = array(
    $this->t('admin', 'update')  => $this->createUrl("index", array("menu_id" => $model->menu->id))
);

echo $form
?>
