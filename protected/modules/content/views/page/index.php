<? $this->page_title = null; ?>

<?
$this->widget('zii.widgets.CListView', [
    'id'           => 'Page-listView',
    'dataProvider' => $data_provider,
    'summaryText'  => '',
    'itemView'     => '_view',
    'viewData'     => ['preview' => true],
    'emptyText'    => t('Посты еще не были добавлены')
]);
?>