<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/MailerLetterForm.js');

echo $form;