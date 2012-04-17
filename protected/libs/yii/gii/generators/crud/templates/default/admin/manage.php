<?php
echo '<?php

$this->tabs = array(
    \'добавить\' => $this->createUrl(\'create\')
);';
?>

<?php echo "\n"; ?>$this->widget('GridView', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
    if ($column->name == 'id')
    {
        continue;
    }

	if(++$count==7)
		echo "\t\t/*\n";

    if ($column->name == 'user_id')
    {
        echo "\t\t" . 'array(\'name\' => \'user_id\', \'value\' => \'$data->user->name\')' . ",\n";
    }
    else
    {
        echo "\t\tarray('name' => '".$column->name."'),\n";
    }
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 

