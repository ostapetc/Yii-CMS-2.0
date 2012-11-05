<? $this->page_title = null; ?>

<?
$this->widget('ListView', [
    'id'           => 'search',
    'dataProvider' => $dp,
    'summaryText'  => '',
    'itemView'     => '_view',
    'viewData'     => ['preview' => true],
    'emptyText'    => t('Посты еще не были добавлены')
]);
