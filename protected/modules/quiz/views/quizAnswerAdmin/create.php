<?
$this->page_title = 'Новый вариант ответа на вопрос';
$this->tabs = array(
    'управление вариантами ответов'  => $this->createUrl('manage'),
);
?>

<?= $question->text ?>

<?= $form ?>