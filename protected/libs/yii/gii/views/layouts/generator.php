<? $this->beginContent('gii.views.layouts.main'); ?>
<div class="container">
	<div class="span-4">
		<div id="sidebar">
		<? $this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Generators',
		)); ?>
			<ul>
				<? foreach($this->module->controllerMap as $name=>$config): ?>
				<li><? echo CHtml::link(ucwords(CHtml::encode($name).' generator'),array('/gii/'.$name));?></li>
				<? endforeach; ?>
			</ul>
		<? $this->endWidget(); ?>
		</div><!-- sidebar -->
	</div>
	<div class="span-16">
		<div id="content">
			<? echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-4 last">
		&nbsp;
	</div>
</div>
<? $this->endContent(); ?>