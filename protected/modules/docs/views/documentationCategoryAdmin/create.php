<?php
$this->page_title = $this->t('admin', 'create');

$this->tabs = array(
    $this->t('admin', 'manage')  => $this->createUrl("manage"),
    $this->t('admin', 'sorting') => $this->createUrl("sorting"),

);

echo $form;