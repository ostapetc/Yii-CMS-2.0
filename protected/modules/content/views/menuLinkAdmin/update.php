<?php
Yii::app()->getClientScript()->registerScriptFile('/js/modules/content/menuLinkForm.js');

$this->page_title = $model->menu->name . " :: " . t('редактирование ссылки');

echo $form
?>
