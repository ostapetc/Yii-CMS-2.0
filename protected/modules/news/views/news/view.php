<?php
if ($model->photo)
{
    $thumb = ImageHelper::thumb(
        News::PHOTOS_DIR,
        $model->photo,
        News::PHOTO_BIG_WIDTH,
        null,
        false
    );
}
?>

<?php if (isset($thumb)): ?>
    <?php echo $thumb; ?>
    <br/>
    <br/>
<?php endif ?>

<?php echo $model->content; ?>

<br clear='all' />

<?php $this->widget('fileManager.portlets.FileList', array(
    'model' => $model,
    'tag' => 'files'
)) ?>



