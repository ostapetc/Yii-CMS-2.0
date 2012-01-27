<style type="text/css">
#meta_tags_l {
    margin-bottom: 20px !important;
    text-decoration: underline;
    display: block;
}
</style>

<div id="<?php echo $this->id ?>" style="display: none">

    <p>
    <?php echo CHtml::activeLabel($model, 'title'); ?>
    <?php echo CHtml::activeTextField($model, 'title', array('class' => 'text')); ?>
    </p>

    <p>
    <?php echo CHtml::activeLabel($model, 'keywords'); ?>
    <?php echo CHtml::activeTextField($model, 'keywords', array('class' => 'text')); ?>
    </p>

    <p>
    <?php echo CHtml::activeLabel($model, 'description'); ?>
    <?php echo CHtml::activeTextField($model, 'description', array('class' => 'text')); ?>
    </p>

</div>


