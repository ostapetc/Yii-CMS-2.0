<div class="form login">
<? $form=$this->beginWidget('CActiveForm'); ?>
	<p>Please enter your password</p>

	<? echo $form->passwordField($model,'password'); ?>
	<? echo $form->error($model,'password'); ?>

	<? echo CHtml::submitButton('Enter'); ?>

<? $this->endWidget(); ?>
</div><!-- form -->
