<?php

Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/MetaTagForm.js');

$this->tabs = array(
    'управление' => $this->createUrl('manage'),
    'просмотр'   => $this->createUrl('view', array('id' => $form->model->id))
);

echo $form;