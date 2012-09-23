<div>
    <div style="float: left; width:305px;">
        <iframe src="<?= $data->player_url ?>"></iframe>
    </div>
    <div style="float: left; width:250px;">
        <a href="#" class="icon-random" data-clip="<iframe src='<?= $data->player_url ?>'></iframe>"></a>
        <b><?= $data->title ?></b>
        Показы: <?= $data->view_count ?>
        <br/>
        Проголосовало: <?= $data->raters ?>
        <br/>
        Рейтинг: <?= $data->average ?>
        <br/>
        Автор: <?= CHtml::link($data->author_name, $data->author_uri, array("target"=> "_blank")) ?>
        Категория: <?= $data->category ?>
    </div>
</div>
<div class="clear"></div>
<hr/>