<?
$this->widget('ListView', array(
    'id'           => 'Page-listView',
    'dataProvider' => $data_provider,
    'summaryText'  => '',
    'itemView'     => '_view',
    'viewData'     => array('preview' => true),
    //'itemCssClass' => 'page',
));
?>