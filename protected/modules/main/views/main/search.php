<? $this->page_title = Yii::t("main", "Результаты поиска"); ?>

<? if ($result): ?>
    <? foreach ($result as $view_path => $items): ?>
        <? if ($items): ?>
            <? foreach ($items as $data): ?>
                <? $this->renderPartial($view_path, $data); ?>
            <? endforeach ?>
        <? endif ?>
    <? endforeach ?>
<? else: ?>
    <? echo $this->msg("По запросу '{$query}' ничего не найдено", "ok"); ?>
<? endif ?>

