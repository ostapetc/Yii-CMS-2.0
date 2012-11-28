<?php
if ($is_big == 1)
{
    $this->page_title = 'Добавление горизонтального баннера';
}
else
{
    $this->page_title = 'Добавление вертикального баннера';
}

Yii::app()->clientScript->registerScriptFile(
    $this->module->assetsUrl() . '/js/BannerForm.js'
);

$this->tabs = array(
    'вертикальные баннеры'   => $this->createUrl('manage', array('is_big' => 0)),
    'горизонтальные баннеры' => $this->createUrl('manage', array('is_big' => 1))
);

echo $form;
?>


