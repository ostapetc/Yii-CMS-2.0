<?php $this->meta_title = $this->page_title = $model->title; ?>
<div id="right_column">
    <?php $this->renderPartial('//layouts/sidebar') ?>
</div>
<div id="big_column">
    <?php
    $this->widget('Breadcrumbs', array(
        'links' => array(
            'Полезное' => '/useful',
            'Модный глоссарий' => Glossary::mainUrl(),
            ApPagination::getFirstLetter($model->title) => $this->url('index', array('Glossary_alphapage' => ApPagination::getWordIndex($model->title))),
            $model->title
        )
    ))
    ?>

    <?php echo $model->content; ?>
</div>