<!--<ul class="nav nav-pills">-->
<!--    <li class=""><a href="#labels">Labels</a></li>-->
<!--    <li class=""><a href="#badges">Badges</a></li>-->
<!--    <li class=""><a href="#typography">Typography</a></li>-->
<!--    <li class=""><a href="#thumbnails">Thumbnails</a></li>-->
<!--    <li class=""><a href="#alerts">Alerts</a></li>-->
<!--    <li class=""><a href="#progress">Progress bars</a></li>-->
<!--    <li class=""><a href="#misc">Miscellaneous</a></li>-->
<!--</ul>-->

<?
$this->widget('zii.widgets.CMenu', array(
    'items'       => $items,
    'htmlOptions' => array(
        'class' => 'nav nav-pills'
    )
));
?>