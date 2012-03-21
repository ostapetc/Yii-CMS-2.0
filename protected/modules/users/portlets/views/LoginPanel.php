<li>
    <?php
    echo CHtml::link('Login', '#login', array('data-toggle'=> "modal"));
    ?>
</li>
<?php
$this->beginWidget('BootModal', array(
    'htmlOptions'=> array(
        'id'=> 'login'
    )
)) ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>

    <h3><?php echo $title ?></h3>
</div>

<div class="modal-body">
    <?php
    $this->widget('BootTabbed', array(
        'tabs' => array(
            array(
                'content'=> $login_form,
                'label'=>'Вход',
            ),
            array(
                'content'=> $register_form ,
                'label'=>'Регистрация',
            ),
            array(
                'label'=>'Забыли пароль?',
                'content'=> $forgot_form ,
            )
        )
    ));
    ?>
</div>
<div class="modal-footer">
</div>
<?php $this->endWidget() ?>
