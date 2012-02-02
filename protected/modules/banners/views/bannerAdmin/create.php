<?php
Yii::app()->clientScript->registerScriptFile(
    $this->module->assetsUrl() . '/js/BannerForm.js'
);

$this->tabs = array(
    $this->t('admin', 'manage') => $this->createUrl('manage')
);

echo $form;
?>


