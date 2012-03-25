<?
$this->page_title = 'Добавление операции';
?>

<? if ($modules): ?>
    <? echo $form; ?>
<? else: ?>
    <? echo $this->msg("Все задачи уже добавлены!", "info"); ?>
<? endif ?>
