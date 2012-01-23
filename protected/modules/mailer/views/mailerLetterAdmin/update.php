<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/MailerLetterForm.js');

$this->tabs = array(
    'Отчет об отправке' => $this->createUrl('manage'),
    'просмотр'   => $this->createUrl('view', array('id' => $form->model->id))
);

echo $form;