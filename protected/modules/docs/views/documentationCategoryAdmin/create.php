<?php
$this->page_title = $this->t('admin', 'create');

$this->tabs = array(
    $this->t('admin', 'manage')  => $this->url("manage"),
    $this->t('admin', 'sorting') => $this->url("sorting"),

);

echo $form;