<?
$this->page_title = 'Редактирование настройки';
$this->tabs = array(
    'Просмотр'      => $this->createUrl('view', array('id' => $form->model->id)),
    'Все настройки' => $this->createUrl('manage')
);
?>

<?= $form ?>