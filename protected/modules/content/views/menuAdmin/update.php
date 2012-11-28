<?
$this->page_title = 'Добавление меню сайта'; 

$this->tabs = [
	'добавить меню'   => $this->createUrl('create'),
	'управление меню' => $this->createUrl('manage')
];

echo $form;
