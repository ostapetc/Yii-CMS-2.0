<style type="text/css">
    .user-page-sidebar a {
        display: inline-block !important;
    }
</style>

<h4><?= $title ?></h4>

<?
$this->widget('zii.widgets.CMenu', array(
    'items'       => $items,
    'htmlOptions' => array(
        'class' => 'nav nav-pills nav-stacked user-page-sidebar'
    ),
    'encodeLabel' => false,
    'activateItems' => false
))
?>
