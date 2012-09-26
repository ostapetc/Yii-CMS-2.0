<? $this->page_title = null; ?>

<?
$this->widget('ListView', array(
    'id'           => 'Page-listView',
    'dataProvider' => $data_provider,
    'summaryText'  => '',
    'itemView'     => '_view',
    'viewData'     => array('preview' => true),
    'emptyText'    => t('Посты еще не были добавлены')
));
?>