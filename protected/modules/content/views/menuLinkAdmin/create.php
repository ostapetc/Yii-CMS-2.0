<?php
$this->tabs = array(
    $this->t('admin', 'manage')  => $this->createUrl("index", array("menu_id" => $model->menu->id))
);

echo $form;
