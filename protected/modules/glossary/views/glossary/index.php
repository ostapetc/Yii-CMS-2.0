<?php $this->meta_title = $this->page_title = Yii::t('GlossaryModule.main', 'Модный глоссарий'); ?>
<div id="right_column">
    <?php $this->renderPartial('//layouts/sidebar') ?>
</div>
<div id="big_column">
    <?php $this->widget('Breadcrumbs', array(
        'links' => array(
            'Полезное' => '/useful',
            'Модный глоссарий'
        )
    )) ?>

    <div class="block_page">

        <div class="block_page_left">
            <?php $this->widget('glossary.components.MultilangApListView',array(
                'dataProvider'=>$dp,
                'itemView' => '_list'
            )); ?>
        </div>

    </div>
</div>