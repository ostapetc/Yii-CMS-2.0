<h1>Controller Generator</h1>

<p>This generator helps you to quickly generate a new controller class,
one or several controller actions and their corresponding views.</p>

<? $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

	<div class="row">
		<? echo $form->labelEx($model,'controller'); ?>
		<? echo $form->textField($model,'controller',array('size'=>65)); ?>
		<div class="tooltip">
			Controller ID is case-sensitive. Below are some examples:
			<ul>
				<li><code>post</code> generates <code>PostController.php</code></li>
				<li><code>postTag</code> generates <code>PostTagController.php</code></li>
				<li><code>admin/user</code> generates <code>admin/UserController.php</code>.
					If the application has an <code>admin</code> module enabled,
					it will generate <code>UserController</code> within the module instead.
				</li>
			</ul>
		</div>
		<? echo $form->error($model,'controller'); ?>
	</div>

	<div class="row sticky">
		<? echo $form->labelEx($model,'baseClass'); ?>
		<? echo $form->textField($model,'baseClass',array('size'=>65)); ?>
		<div class="tooltip">
			This is the class that the new controller class will extend from.
			Please make sure the class exists and can be autoloaded.
		</div>
		<? echo $form->error($model,'baseClass'); ?>
	</div>

	<div class="row">
		<? echo $form->labelEx($model,'actions'); ?>
		<? echo $form->textField($model,'actions',array('size'=>65)); ?>
		<div class="tooltip">
			Action IDs are case-insensitive. Separate multiple action IDs with commas or spaces.
		</div>
		<? echo $form->error($model,'actions'); ?>
	</div>

<? $this->endWidget(); ?>
