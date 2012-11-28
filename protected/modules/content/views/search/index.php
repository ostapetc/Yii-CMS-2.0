<? $this->page_title = null; ?>
<div class="search">
    <?
    Yii::app()->clientScript->registerCssFile('/css/site/search.css');
    $this->widget('ListView', [
        'id'           => 'search-result',
        'dataProvider' => $dp,
        'summaryText'  => '',
        'itemView'     => '_view',
        'viewData'     => ['preview' => true],
        'emptyText'    => t('Посты еще не были добавлены')
    ]);
    ?>
</div>