<?php

Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/MetaTagForm.js');

$this->tabs = array(
    'управление мета-тегами' => $this->createUrl('manage')
);

echo $form;

