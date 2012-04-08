<?
/**
 * This is the template for generating a form script file.
 * The following variables are available in this template:
 * - $this: the FormCode object
 */
?>
<div class="form">

<? echo "<? \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass).'-'.basename($this->viewName)."-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<? echo "<? echo \$form->errorSummary(\$model); ?>\n"; ?>

<? foreach($this->getModelAttributes() as $attribute): ?>
	<div class="row">
		<? echo "<? echo \$form->labelEx(\$model,'$attribute'); ?>\n"; ?>
		<? echo "<? echo \$form->textField(\$model,'$attribute'); ?>\n"; ?>
		<? echo "<? echo \$form->error(\$model,'$attribute'); ?>\n"; ?>
	</div>

<? endforeach; ?>

	<div class="row buttons">
		<? echo "<? echo CHtml::submitButton('Submit'); ?>\n"; ?>
	</div>

<? echo "<? \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->