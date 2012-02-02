<?php
$this->page_title = 'Редактирование раздела FAQ';

$this->tabs = array(
    $this->t('admin', 'update') => $this->createUrl("manage")
);

echo $form;
?>