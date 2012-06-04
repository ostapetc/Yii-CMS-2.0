<div>
    <div>Альбомы</div>
    <?
    $this->beginWidget('BootModal', array(
        'htmlOptions' => array(
            'id' => 'create_album_modal'
        )
    )) ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Создание альбома</h3>
    </div>
    <div class="modal-body">
        <?
        $form->activeForm['clientOptions']['afterValidate'] = 'js:function($form, data, hasError) {
            if (!hasError)
            {
                $.fn.yiiListView.update("albums");
                $("#create_album_modal").modal("hide");
                $form.get(0).reset();
            }
            return false;
        }';
        echo $form;
        ?>
    </div>
    <? $this->endWidget('BootModal') ?>
    <a data-toggle="modal" href="#create_album_modal">Создать альбом</a>
    <?
    $dp = Yii::app()->getModule('fileManager')->getAlbumsDataProvider($model);
    $dp->pagination = false;
    $this->widget('ListView', array(
        'template' => "{pager}\n{items}\n{pager}",
        'dataProvider' => $dp,
        'itemView' => '_album',
        'id'=>'albums'
    ));
    ?>
</div>