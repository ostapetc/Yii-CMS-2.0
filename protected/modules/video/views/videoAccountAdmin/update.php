<?
$this->tabs = array(
    'управление аккаунтами' => $this->createUrl('manage'),
    'просмотр'              => $this->createUrl('view', array('id' => $form->model->id)),
);
?>


<?= $form ?>