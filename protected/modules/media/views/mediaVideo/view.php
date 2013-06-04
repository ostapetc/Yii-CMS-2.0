<? $this->page_title = $model->title ?>
<div class="video-view">
    <div class="video-container">
        <?= $model->getPlayer([
            'width'=> 670,
            'height' => 360,
        ]);
        ?>
    </div>

    <?
    $this->renderPartial('_infoPanel', ['model' => $model]);
    ?>
    <br/>
    <br/>
    <?
    $this->widget('comments.portlets.CommentsPortlet', array(
        'model' => $model
    ));
    ?>
</div>
