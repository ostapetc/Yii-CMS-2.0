<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
<!--            <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">-->
<!--                <span class="icon-bar"></span>-->
<!--                <span class="icon-bar"></span>-->
<!--                <span class="icon-bar"></span>-->
<!--            </a>-->
            <a href="/" class="brand">
                What name?
            </a>
            <div class="nav-collapse">
                <?
                $this->widget('BootMenu', array(
                    'items'       => $items
                ))
                ?>
                <form action="" class="navbar-search pull-left">
                    <input type="text" placeholder="Поиск" value="<?= $query ?>" class="search-query span2">
                </form>
                <ul class="nav pull-right" style="margin-right: 0;">
                    <? if (Yii::app()->user->isGuest): ?>
                        <li><?= CHtml::link(t('Войти'), array('/users/user/login'), array('class' => 'modal-link', 'data-title' => 'Авторизация')); ?></li>
                        <li class="divider-vertical"></li>
                        <li><?= CHtml::link(t('Регистрация'), array('/users/user/registration')); ?></li>
                    <? else: ?>
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle user-menu" href="#"><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="/">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding-right: 10px;">
                                                    <?= Yii::app()->user->model->photo_link ?>
                                                </td>
                                                <td style="line-height: 14px;">
                                                    <b><?= Yii::app()->user->model->name ?></b> <br/>
                                                    <small class="grey">показать мой профиль</small>
                                                </td>
                                            </tr>
                                        </table>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <?= CHtml::link('<span class="glyphicon-message-plus"></span> &nbsp;' . t('Личные сообщения'), '') ?>
                                </li>
                                <li class="divider"></li>
                                <li><?= CHtml::link('<span class="glyphicon-new-window"></span> &nbsp;' . t('Выйти'), array('/users/user/logout')) ?></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle create-menu" href="#"><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <?= CHtml::link('<span class="glyphicon-file"></span> &nbsp;' . t('Создать пост'), array('/content/page/create')) ?>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <?= CHtml::link('<span class="glyphicon-facetime-video"></span> &nbsp;' . t('Добавить видео'), array('/video/video/create')) ?>
                                </li>
                            </ul>
                        </li>
                    <? endif ?>
                </ul>
            </div>
        </div>
    </div>
</div>


