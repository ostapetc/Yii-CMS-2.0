<div class="row template sticky">
	<? echo $this->labelEx($model,'template'); ?>
	<? echo $this->dropDownList($model,'template',$templates); ?>
	<div class="tooltip">
		Please select which set of the templates should be used to generated the code.
	</div>
	<? echo $this->error($model,'template'); ?>
</div>

<div class="buttons">
	<? echo CHtml::submitButton('Preview',array('name'=>'preview')); ?>

	<? if($model->status===CCodeModel::STATUS_PREVIEW && !$model->hasErrors()): ?>
		<? echo CHtml::submitButton('Generate',array('name'=>'generate')); ?>
	<? endif; ?>
</div>

<? if(!$model->hasErrors()): ?>
	<div class="feedback">
	<? if($model->status===CCodeModel::STATUS_SUCCESS): ?>
		<div class="success">
			<? echo $model->successMessage(); ?>
		</div>
	<? elseif($model->status===CCodeModel::STATUS_ERROR): ?>
		<div class="error">
			<? echo $model->errorMessage(); ?>
		</div>
	<? endif; ?>

	<? if(isset($_POST['generate'])): ?>
		<pre class="results"><? echo $model->renderResults(); ?></pre>
	<? elseif(isset($_POST['preview'])): ?>
		<? echo CHtml::hiddenField("answers"); ?>
		<table class="preview">
			<tr>
				<th class="file">Code File</th>
				<th class="confirm">
					<label for="check-all">Generate</label>
					<?
						$count=0;
						foreach($model->files as $file)
						{
							if($file->operation!==CCodeFile::OP_SKIP)
								$count++;
						}
						if($count>1)
							echo '<input type="checkbox" name="checkAll" id="check-all" />';
					?>
				</th>
			</tr>
			<? foreach($model->files as $i=>$file): ?>
			<tr class="<? echo $file->operation; ?>">
				<td class="file">
					<? echo CHtml::link(CHtml::encode($file->relativePath), array('code','id'=>$i), array('class'=>'view-code','rel'=>$file->path)); ?>
					<? if($file->operation===CCodeFile::OP_OVERWRITE): ?>
						(<? echo CHtml::link('diff', array('diff','id'=>$i), array('class'=>'view-code','rel'=>$file->path)); ?>)
					<? endif; ?>
				</td>
				<td class="confirm">
					<?
					if($file->operation===CCodeFile::OP_SKIP)
						echo 'unchanged';
					else
					{
						$key=md5($file->path);
						echo CHtml::label($file->operation, "answers_{$key}")
							. ' ' . CHtml::checkBox("answers[$key]", $model->confirmed($file));
					}
					?>
				</td>
			</tr>
			<? endforeach; ?>
		</table>
	<? endif; ?>
	</div>
<? endif; ?>
