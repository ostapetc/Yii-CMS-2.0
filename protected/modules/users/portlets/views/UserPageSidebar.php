<h4><?= $title ?></h4>

<?
$this->widget('zii.widgets.CMenu', array(
    'items'       => $items,
    'htmlOptions' => array(
        'class' => 'nav nav-pills nav-stacked',
    ),
    'encodeLabel' => false
))
?>
