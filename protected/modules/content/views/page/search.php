<?
$this->page_title = t('Результаты поиска');
$this->crumbs = array(t('Поиск'));
?>

<br/>

<? if (isset($pages)): ?>
    <? if ($pages): ?>
        <? foreach ($pages as $page): ?>
            <h3><a href="<? echo $page->href; ?>"><? echo $page->title; ?></a></h3>
            <? echo TextHelper::cut($page->text, 300); ?>

            <br clear="all" />
            <br clear="all" />
        <? endforeach ?>
    <? else: ?>
    <div class="alert alert-warning">По данному заросу ничего не найдено</div>
    <? endif ?>
<? else: ?>
    <div class="alert alert-error">Слишком короткий запрос поиска,  не меньше трёх символов!</div>
<? endif ?>