<?php

foreach( $list as $row ):

echo CHtml::link( $row['title'], $row['loc']);
echo CHtml::tag('br');

endforeach;

?>
