<?php 
$this->page_title = 'Добавление меню сайта';

$this->tabs = array(
    $this->t('admin', 'manage')  => $this->createUrl('manage')
);

echo $form 
?>