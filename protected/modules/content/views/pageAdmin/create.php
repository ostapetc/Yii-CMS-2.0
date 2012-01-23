<?php
$this->page_title = 'Добавление страницы';

$this->tabs = array(
    "список страниц" => $this->createUrl('manage')
);

echo $form;
?>