<style type="text/css">
#meta_tags_fs {
    display: none;
}

#meta_tags_l {
    margin-bottom: 20px !important;
    text-decoration: underline;
    display: block;
}
</style>


<script type="text/javascript">
$(function()
{
    $('#meta_tags_l').live('click', function()
    {
        $('#meta_tags_fs').slideDown();
        $(this).remove();
        return false;
    });
});
</script>



<?php $class = get_class($this->model); ?>

<a href="" id="meta_tags_l">Мета-тэги</a>

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


