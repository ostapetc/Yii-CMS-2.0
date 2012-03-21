<?php
$this->page_title = t('Добавление блока страницы');

$this->tabs = array(
    'все блоки' => $this->createUrl('manage')
);
?>

<?php echo $form; ?>