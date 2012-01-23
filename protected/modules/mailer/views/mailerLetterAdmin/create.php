<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/MailerLetterForm.js');

$this->tabs = array(
    'Отчеты о рассылках' => $this->createUrl('manage')
);

echo $form;