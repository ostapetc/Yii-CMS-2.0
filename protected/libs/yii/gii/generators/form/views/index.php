<h1>Form Generator</h1>

<p>This generator generates a view script file that displays a form to collect input for the specified model class.</p>

<? $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

	<div class="row">
		<? echo $form->labelEx($model,'model'); ?>
		<? echo $form->textField($model,'model', array('size'=>65)); ?>
		<div class="tooltip">
			Model class is case-sensitive. It can be either a class name (e.g. <code>Post</code>)
		    or the path alias of the class file (e.g. <code>application.models.LoginForm</code>).
		    Note that if the former, the class must be auto-loadable.
		</div>
		<? echo $form->error($model,'model'); ?>
	</div>
	<div class="row">
		<? echo $form->labelEx($model,'viewName'); ?>
		<? echo $form->textField($model,'viewName', array('size'=>65)); ?>
		<div class="tooltip">
			This refers to the name of the view script to be generated, for example,
			<code>site/contact</code>, <code>user/login</code>. The actual view script file will be generated
			under the View Path specified below.
		</div>
		<? echo $form->error($model,'viewName'); ?>
	</div>
	<div class="row sticky">
		<? echo $form->labelEx($model,'viewPath'); ?>
		<? echo $form->textField($model,'viewPath', array('size'=>65)); ?>
		<div class="tooltip">
			This refers to the directory that the new view script file should be generated under.
			It should be specified in the form of a path alias, for example, <code>application.views</code>,
			<code>mymodule.views</code>.
		</div>
		<? echo $form->error($model,'viewPath'); ?>
	</div>
	<div class="row">
		<? echo $form->labelEx($model,'scenario'); ?>
		<? echo $form->textField($model,'scenario', array('size'=>65)); ?>
		<div class="tooltip">
			This refers to the scenario in which the model should be used to collect user input.
			For example, a <code>User</code> model can be used in both <code>login</code> and <code>register</code> scenarios.
			To create a form for the login purpose, the scenario should be specified as <code>login</code>.
			Leave this empty if the model does not need to differentiate scenarios.
		</div>
		<? echo $form->error($model,'scenario'); ?>
	</div>

<? $this->endWidget(); ?>
