<? $this->page_title = $model->title ?>
<div class="video-view">
    <div class="video-container">
        <?= $model->getPlayer(['width' => 670, 'height' => 400]) ?>
    </div>
</div>