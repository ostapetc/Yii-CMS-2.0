<style type="text/css">
    .save_alias, .meta-tags-form{display: none}
</style>
<?php $class = get_class($this->model); ?>
<div id="<?php echo $this->id ?>" class="meta-tags-form">


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
