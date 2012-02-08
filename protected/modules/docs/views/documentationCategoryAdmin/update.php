<?php
$this->page_title = $this->t('admin', 'update');

$this->tabs = array(
    $this->t('admin', 'manage')  => $this->createUrl("manage"),
    $this->t('admin', 'sorting') => $this->createUrl("sorting"),
    $this->t('admin', 'create')  => $this->createUrl("create", array('parent_id'=>1)),
);

echo $form;