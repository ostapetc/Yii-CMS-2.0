<div class="page">
<div class="content-type">Пост: </div>
<div class="title">
    <a href="<?= $data->model->url ?>">
        <?= $data->model->title ?>
    </a>
</div>

<div class="descr">
    <?= $data->model->text_search ?>
</div>

<?
$this->renderPartial('/page/_infoPanel', ['page' => $data->model]);
?>
<div class="clear"></div>
</div>