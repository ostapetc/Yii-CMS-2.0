<?php

$this->tabs = array(
    'управление шаблонами рассылки' => $this->createUrl('manage'),
    'просмотр'   => $this->createUrl('view', array('id' => $form->model->id))
);

echo $form;