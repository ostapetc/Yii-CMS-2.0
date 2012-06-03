<div>
    <div>Альбомы</div>
    <?
    $form = new Form('FileManager.AlbumForm', $model->getNewAttachedModel('FileAlbum'));
    $form->action = '/fileManager/fileAlbum/create';
    $form->activeForm['clientOptions']['afterValidate'] = 'js:function($form, data, hasError) {
        if (!hasError)
        {
            $form.submit(function() {
                $.fn.yiiListView.update("albums");
            });
        }
        return false;
    }';
    echo $form;
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