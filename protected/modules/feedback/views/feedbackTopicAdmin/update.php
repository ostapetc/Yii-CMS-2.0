<?php
$this->crumbs = array(
    'Список тем' => $this->createUrl('manage'),
    'Редактирование темы'
);

$this->tabs = array(
    'Список тем' => $this->createUrl('manage'),
);

echo $form;