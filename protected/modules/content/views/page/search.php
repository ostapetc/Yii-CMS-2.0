<?php
$this->page_title = t('Результаты поиска');
$this->crumbs = array(t('Поиск'));
?>

<br/>

<?php if (isset($pages)): ?>
    <?php if ($pages): ?>
        <?php foreach ($pages as $page): ?>
            <h3><a href="<?php echo $page->href; ?>"><?php echo $page->title; ?></a></h3>
            <?php echo TextHelper::cut($page->text, 300); ?>

            <br clear="all" />
            <br clear="all" />
        <?php endforeach ?>
    <?php else: ?>
    <div class="alert alert-warning">По данному заросу ничего не найдено</div>
    <?php endif ?>
<?php else: ?>
    <div class="alert alert-error">Слишком короткий запрос поиска,  не меньше трёх символов!</div>
<?php endif ?>