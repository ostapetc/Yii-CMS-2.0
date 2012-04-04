<div class="wide form">

<? $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<? echo $form->label($model,'id'); ?>
		<? echo $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'language'); ?>
		<? echo $form->textField($model,'language',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'title'); ?>
		<? echo $form->textField($model,'title',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'url'); ?>
		<? echo $form->textField($model,'url',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'text'); ?>
		<? echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'is_published'); ?>
		<? echo $form->textField($model,'is_published'); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'date_create'); ?>
		<? echo $form->textField($model,'date_create'); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'order'); ?>
		<? echo $form->textField($model,'order'); ?>
	</div>

	<div class="row buttons">
		<? echo CHtml::submitButton('Search'); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- search-form -->