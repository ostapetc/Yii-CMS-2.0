<style type="text/css">
    .rankins-tbl {
        width: 700px;
    }

    .rankins-tbl>td {
        width: 50%;
    }
</style>

<? $this->page_title = 'TOP 10 Sherdog.com' ?>

<table class="rankins-tbl">
    <tr>
        <td>
            <h5>Тяжелый вес</h5>
            <? $this->renderPartial('_rankingTable', array('fighters' => $fighters)) ?>
        </td>
        <td>
            <h5>Средний тяжелый вес</h5>
            <? $this->renderPartial('_rankingTable', array('fighters' => $fighters)) ?>
        </td>
    </tr>
    <tr>
        <td>
            <h5>Средний вес</h5>
            <? $this->renderPartial('_rankingTable', array('fighters' => $fighters)) ?>
        </td>
        <td>
            <h5>Средний легкий вес</h5>
            <? $this->renderPartial('_rankingTable', array('fighters' => $fighters)) ?>
        </td>
    </tr>
    <tr>
        <td>
            <h5>Легкий вес</h5>
            <? $this->renderPartial('_rankingTable', array('fighters' => $fighters)) ?>
        </td>
    </tr>
</table>