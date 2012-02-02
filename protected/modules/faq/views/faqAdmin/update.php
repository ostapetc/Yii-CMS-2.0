<?php
$this->page_title = 'Редактирование вопроса';

$this->tabs = array(
    $this->t('admin', 'manage') => $this->createUrl("manage"),
);

echo $form;
?>