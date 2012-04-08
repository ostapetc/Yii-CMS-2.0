<? echo "<? \n"; ?>$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
<?
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); 
?>

