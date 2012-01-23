<?php 
$this->tabs = array(
    'Управление задачами' => $this->createUrl('manage'),
    'Просмотр' => $this->createUrl('view', array('id' => $form->model->name)),
);

echo $form; 
?>
