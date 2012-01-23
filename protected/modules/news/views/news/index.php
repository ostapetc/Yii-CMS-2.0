<?php 
$this->page_title = Yii::t('NewsModule.main', 'Новости');

//$this->renderPartial('_list', array('news_list' => $news_list));
//
//$this->renderPartial('application.views.layouts.pagination', array('pages' => $pages));

$this->widget('zii.widgets.CListView', array(
    'dataProvider'     => $data_provider,
    'itemView'         => '_view',
    'emptyText'        => $this->msg(Yii::t('main', 'ничего не найдено'), 'info'),
    'enablePagination' => true,
    'summaryText'      => false,
    'ajaxUpdate'       => false,
    'pager' => array(
        'class'   => 'CLinkPager',

    )
));
?>
