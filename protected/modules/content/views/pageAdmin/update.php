<?php
$this->page_title = t('Рекдирование страницы');

$this->tabs = array(
    'список страниц'    => $this->createUrl('manage'),
    'просмотр страницы' => $this->createUrl('view', array('id' => $form->model->id))
);

echo $form;
?>