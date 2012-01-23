<?php
Yii::app()->clientScript->registerScriptFile(
    $this->module->assetsUrl() . '/js/BannerForm.js'
);

$this->tabs = array(
    'управление банерами' => $this->createUrl('manage')
);

echo $form;
?>


