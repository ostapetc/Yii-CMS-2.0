<?php $this->page_title = Yii::t("main", "Результаты поиска"); ?>

<?php if ($result): ?>
    <?php foreach ($result as $view_path => $items): ?>
        <?php if ($items): ?>
            <?php foreach ($items as $data): ?>
                <?php $this->renderPartial($view_path, $data); ?>
            <?php endforeach ?>
        <?php endif ?>
    <?php endforeach ?>
<?php else: ?>
    <?php echo $this->msg("По запросу '{$query}' ничего не найдено", "ok"); ?>
<?php endif ?>

