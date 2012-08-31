<h4>Разделы</h4>
<br/>

<?
$this->widget('BootMenu', array(
    'items'       => $sections,
    'encodeLabel' => false,
    'htmlOptions' => array(
        'id' => 'sections-menu'
    )
));
?>