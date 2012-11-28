<? $class = get_class($this->model); ?>
<div id="<? echo $this->id ?>" class="meta-tags-form">

    <p>
        <? echo CHtml::activeLabel($model, 'title'); ?>
        <? echo CHtml::activeTextField($model, 'title', array('class' => 'text')); ?>
    </p>

    <br/>

    <p>
        <? echo CHtml::activeLabel($model, 'keywords'); ?>
        <? echo CHtml::activeTextField($model, 'keywords', array('class' => 'text')); ?>
    </p>

    <br/>

    <p>
        <? echo CHtml::activeLabel($model, 'description'); ?>
        <? echo CHtml::activeTextArea($model, 'description', array('class' => 'text')); ?>
    </p>


</div>
