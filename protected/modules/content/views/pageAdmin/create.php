<?php
$this->page_title = 'Добавление страницы';

$this->tabs = array(
    $this->t('admin', 'manage') => $this->createUrl('manage')
);

echo $form;
?>