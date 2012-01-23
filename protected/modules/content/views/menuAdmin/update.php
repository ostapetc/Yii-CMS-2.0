<?php 
$this->page_title = 'Добавление меню сайта'; 

$this->tabs = array(
	'добавить меню'   => $this->createUrl('create'),
	'управление меню' => $this->createUrl('manage')
);

echo $form;
?>