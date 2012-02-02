<?php
$this->page_title = 'Рекдирование страницы';

$this->tabs = array(
    $this->t('admin', 'manage')  => $this->createUrl('manage')
);

echo $form;
?>