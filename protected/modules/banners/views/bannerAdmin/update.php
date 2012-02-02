<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/BannerForm.js');

$this->tabs = array(
    $this->t('admin', 'manage') => $this->createUrl('manage'),
    $this->t('admin', 'view')   => $this->createUrl('view', array('id' => $form->model->id))
);

echo $form;
?>
