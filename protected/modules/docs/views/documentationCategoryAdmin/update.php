<?php
$this->page_title = $this->t('admin', 'update');

$this->tabs = array(
    $this->t('admin', 'manage')  => $this->url("manage"),
    $this->t('admin', 'sorting') => $this->url("sorting"),
    $this->t('admin', 'create')  => $this->url("create", array('parent_id'=>1)),
);

echo $form;