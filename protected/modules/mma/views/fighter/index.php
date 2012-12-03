<style type="text/css">
    .rankins-tbl {
        width: 700px;
    }

    .rankins-tbl>td {
        width: 50%;
    }
</style>

<? $this->page_title = 'TOP 10 Sherdog.com' ?>

<? foreach ($fighters as $foghter): ?>
    <? $this->renderPartial('_viewSmall', array('fighter' => $foghter)) ?>
<? endforeach ?>