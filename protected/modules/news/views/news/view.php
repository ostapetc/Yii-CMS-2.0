<?php

$this->widget('Crumbs', array(
    'links'=> array(
        t('News') => array('/news/news/index'),
        $model->title
    )
));

if ($model->photo)
{
    echo ImageHelper::thumb(News::PHOTOS_DIR, $model->photo, News::PHOTO_BIG_WIDTH, null, false);
}

echo $model->content;
?>

<br clear='all'/>

<?php
$this->widget('fileManager.portlets.FileList', array(
    'model' => $model,
    'tag'   => 'files'
));

