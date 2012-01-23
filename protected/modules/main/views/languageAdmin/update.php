<?php
$this->page_title = 'Редактирование';

$this->tabs = array(
    'управление языками' => $this->createUrl('manage'),
    'добавить язык'      => $this->createUrl('create'),
    'просмотр'           => $this->createUrl('view', array('id' => $form->model->id))
);

echo $form;
