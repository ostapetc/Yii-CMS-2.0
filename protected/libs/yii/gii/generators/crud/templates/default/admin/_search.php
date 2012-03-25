<?
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="wide form">

<? echo "<? \$form=\$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
)); ?>\n"; ?>

<? foreach($this->tableSchema->columns as $column): ?>
<?
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false)
		continue;
?>
	<div class="row">
		<? echo "<? echo \$form->label(\$model,'{$column->name}'); ?>\n"; ?>
		<? echo "<? echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
	</div>

<? endforeach; ?>
	<div class="row buttons">
		<? echo "<? echo CHtml::submitButton('Search'); ?>\n"; ?>
	</div>

<? echo "<? \$this->endWidget(); ?>\n"; ?>

</div><!-- search-form -->