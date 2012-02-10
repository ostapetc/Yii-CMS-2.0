<?php $class = get_class($this->model); ?>
<div id="<?php echo $this->id ?>" style="display: none">


    <p>
        <?php echo CHtml::activeLabel($model, 'title'); ?>
        <?php echo CHtml::activeTextField($model, 'title', array('class' => 'text')); ?>
    </p>

    <br/>

    <p>
        <?php echo CHtml::activeLabel($model, 'keywords'); ?>
        <?php echo CHtml::activeTextField($model, 'keywords', array('class' => 'text')); ?>
    </p>

    <br/>

    <p>
        <?php echo CHtml::activeLabel($model, 'description'); ?>
        <?php echo CHtml::activeTextField($model, 'description', array('class' => 'text')); ?>
    </p>


</div>
