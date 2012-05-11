<?
$this->tabs = array(
    'управление шаблонами' => $this->createUrl('manage'),
    'просмотр'             => $this->createUrl('view', array('id' => $form->model->id)),
);
?>


<?= $form ?>