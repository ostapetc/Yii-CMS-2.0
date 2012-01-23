<?php
Yii::app()->clientScript->registerScriptFile(
    $this->module->assetsUrl() . '/js/BannerForm.js'
);

$this->tabs = array(
    'управление банерами' => $this->createUrl('manage'),
    'просмотр'            => $this->createUrl('view', array('id' => $form->model->id))
);

echo $form;
?>
