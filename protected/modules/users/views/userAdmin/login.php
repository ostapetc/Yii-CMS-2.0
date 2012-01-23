<style type="text/css">
    .ltable td{
        padding:0 !important;
        border-bottom:0 !important;
    }
</style>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id' => 'user-login-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'niceform')
)); ?>


<?php if ($error_code): ?>
    <?php echo $this->msg($error_code, 'error'); ?>
<?php endif ?>

<p>
    <label><?php echo $form->labelEx($model, 'email'); ?></label>
    <?php echo $form->textField($model, 'email', array('size' => 40, 'class' => 'text')); ?>
    <?php echo $form->error($model,'email'); ?>
</p>

<p>
    <label><?php echo $form->labelEx($model, 'password'); ?></label>
    <?php echo $form->passwordField($model, 'password', array('size' => 40, 'class' => 'text')); ?>
    <?php echo $form->error($model,'password'); ?>
</p>

<p>
    <table cellpadding="0" cellspacing="0" class="ltable">
        <tr>
            <td>
                <?php echo CHtml::submitButton('Войти', array('class' => 'submit', 'id' => 'User_submit')); ?> &nbsp;
            </td>
            <td>
                <?php echo $form->checkbox($model, 'remember_me'); ?>
                &nbsp;
                &nbsp;
            </td>
            <td>
                <?php echo $form->labelEx($model,'remember_me'); ?>
            </td>
        </tr>
    </table>
</p>


<?php $this->endWidget(); ?>




