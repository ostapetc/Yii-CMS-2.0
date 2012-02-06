<div class="modal hide fade" id="login">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>

        <h3><?php echo $title ?></h3>
    </div>
    <div class="modal-body">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#login-tab" data-url="/">Вход</a></li>
            <li><a data-toggle="tab" href="#register-tab" data-url="/">Регистрация</a></li>
            <li><a data-toggle="tab" href="#forgot-tab" data-url="/">Забыли пароль?</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active in" id="login-tab">
                <?php echo $login ?>
            </div>
            <div class="tab-pane fade" id="register-tab">
                <div class="progress progress-info progress-striped active">
                    <div class="bar" style="width: 100%;"></div>
                </div>
            </div>
            <div class="tab-pane fade" id="forgot-tab">
                <div class="progress progress-info progress-striped active">
                    <div class="bar" style="width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <!--        <a href="#" class="btn btn-primary">Save changes</a>-->
        <!--        <a href="#" class="btn">Close</a>-->
    </div>
</div>