<h1>Migration generator</h1>
 
<? $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>
	<? echo $form->hiddenField($model,'_migrateName'); ?>
 
    <div class="row">
        <? echo $form->labelEx($model,'migrateName'); ?>
        <? echo $form->textField($model,'migrateName',array('size'=>65)); ?>
        <div class="tooltip">
            Migration should be only latter
        </div>
        <? echo $form->error($model,'migrateName'); ?>
    </div>

    <div class="row">
        <? echo $form->labelEx($model,'code'); ?>
        <? echo $form->textArea($model,'code',array('rows'=>6, 'cols'=>50)); ?>
        <div class="tooltip">
            SQL code
        </div>
        <? echo $form->error($model,'code'); ?>
    </div>

    <div class="row">
        <? echo $form->labelEx($model,'clearCache'); ?>
        <? echo $form->checkBox($model,'clearCache'); ?>
        <div class="tooltip">
            Is cache need to flush
        </div>
        <? echo $form->error($model,'clearCache'); ?>
    </div>

    <div class="row">
        <? echo $form->labelEx($model,'clearAssets'); ?>
        <? echo $form->checkBox($model,'clearAssets'); ?>
        <div class="tooltip">
            Is assets need to clear
        </div>
        <? echo $form->error($model,'clearAssets'); ?>
    </div>
 
<? $this->endWidget(); ?>