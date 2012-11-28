<?
$this->widget('ListView', [
    'id'           => 'PageSection-listView',
    'dataProvider' => $data_provider,
    'itemView'     => '_view'
]);
?>