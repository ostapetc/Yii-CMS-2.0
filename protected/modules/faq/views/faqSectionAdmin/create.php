<?php
$this->page_title = 'Добавление раздела FAQ';

$this->tabs = array(
    $this->t('admin', 'manage') => $this->createUrl("manage")
);

echo $form;
?>