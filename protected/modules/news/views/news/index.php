<?php
$this->page_title = Yii::t('NewsModule.main', 'Новости');

$this->widget('Crumbs', array(
    'links'=> array(
        t('News') => array('/news/news/index'),
    )
));

$this->widget('ListView', array(
    'dataProvider'     => $data_provider,
    'itemView'         => '_view',
    'emptyText'        => $this->msg(t('ничего не найдено'), 'info'),
    'enablePagination' => true,
    'summaryText'      => false,
));

