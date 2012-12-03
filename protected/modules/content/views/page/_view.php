<div class="page-preview">
    <? if ($data->image_src): ?>
        <?=
        CHtml::link(
            CHtml::image($data->image_src, '', ['class' => 'img-rounded']),
            $data->url,
            [
                'class' => 'page-img'
            ]
        );
        ?>
    <? endif ?>

    <h1><?= CHtml::link(CHtml::encode($data->title), $data->url) ?></h1>

    <?= $data->text_preview ?>

    <? $this->renderPartial('_infoPanel', ['page' => $data,'preview' => true]); ?>
    <? $this->renderPartial('tags.views._list', ['tags' => $data->tags]); ?>
</div>
