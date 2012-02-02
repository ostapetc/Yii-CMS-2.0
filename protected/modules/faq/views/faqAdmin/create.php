<?php
$this->page_title = 'Добавление вопроса';

$this->tabs = array(
    $this->t('admin', 'manage') => $this->createUrl("manage"),
);

echo $form;
?>