<?php
$this->tabs = array(
    'список тем' => $this->createUrl('manage')
);

$this->crumbs = array(
    'Список тем' => $this->createUrl('manage'),
    'Новая тема'
);

echo $form;

