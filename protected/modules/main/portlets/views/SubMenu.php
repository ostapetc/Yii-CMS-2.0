<!--<ul class="breadcrumb">-->
<!--    <li><a href="#">Home</a> <span class="divider">/</span></li>-->
<!--    <li><a href="#">Library</a> <span class="divider">/</span></li>-->
<!--    <li class="active">Data</li>-->
<!--</ul>-->

<?
$this->widget('zii.widgets.CMenu', array(
    'items'       => $items,
    'htmlOptions' => array(
        'class' => 'breadcrumb'
    )
));
?>
