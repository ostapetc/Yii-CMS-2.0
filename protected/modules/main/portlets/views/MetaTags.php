<style type="text/css">
#meta_tags_fs {
}

#meta_tags_l {
    margin-bottom: 20px !important;
    text-decoration: underline;
    display: block;
}
</style>


<?php $class = get_class($this->model); ?>

<fieldset id="meta_tags_fs">
    <legend>Мета-тэги</legend>

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

</fieldset>


