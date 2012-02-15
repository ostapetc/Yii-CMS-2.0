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
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#login-tab">Вход</a></li>
        <li><a data-toggle="tab" href="#register-tab">Регистрация</a></li>
        <li><a data-toggle="tab" href="#forgot-tab">Забыли пароль?</a></li>
    </ul>

    <?php
    $this->widget('BootTabbed', array(
        'tabs' => array(
            array(
                'content'=> $login_form,
                'id'=>'login-tab'
            ),
            array(
                'content'=> $register_form ,
                'id'=>'register-tab'
            ),

        )
    ))
    ?>
<!--    <div class="tab-content">-->
<!--        <div class="tab-pane fade active in" id="login-tab">-->
<!--            --><?php //echo $login_form ?>
<!--        </div>-->
<!--        <div class="tab-pane fade" id="register-tab">-->
<!--            --><?php //echo $register_form ?>
<!--        </div>-->
<!--        <div class="tab-pane fade" id="forgot-tab">-->
<!--            --><?php //echo $forgot_form ?>
<!--        </div>-->
<!--    </div>-->
</div>
<div class="modal-footer">
    <!--        <a href="#" class="btn btn-primary">Save changes</a>-->
    <!--        <a href="#" class="btn">Close</a>-->
</div>
<?php $this->endWidget() ?>
