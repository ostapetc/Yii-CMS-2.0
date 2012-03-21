<?
$this->page_title = t('Редактирование блока страницы');
$this->tabs = array(
    'Просмотр'  => $this->createUrl('view', array('id' => $form->model->id)),
    'Все блоки' => $this->createUrl('manage')
);
?>

<?php echo $form; ?>