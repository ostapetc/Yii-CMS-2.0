<?php
$this->page_title = $this->t('admin', 'create');

$this->tabs = array(
    $this->t('admin', 'manage') => $this->createUrl("manage")
);

echo $form;
?>