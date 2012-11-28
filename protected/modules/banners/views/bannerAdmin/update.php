<?php
Yii::app()->clientScript->registerScriptFile(
    $this->module->assetsUrl() . '/js/BannerForm.js'
);

$this->tabs = array(
    'вертикальные баннеры'   => $this->createUrl('manage', array('is_big' => 0)),
    'горизонтальные баннеры' => $this->createUrl('manage', array('is_big' => 1)),
    'просмотр'               => $this->createUrl('view', array('id' => $form->model->id))
);

echo $form;
?>
