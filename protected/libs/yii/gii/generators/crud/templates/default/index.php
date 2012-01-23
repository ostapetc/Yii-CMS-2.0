<?php echo "<?php\n"; ?>

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