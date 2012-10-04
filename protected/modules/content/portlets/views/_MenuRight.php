<ul class="nav pull-right" style="margin-right: 0;">
    <? if (Yii::app()->user->isGuest): ?>
        <li><?= CHtml::link(t('Войти'), array('/users/user/login'), array(
            'class'      => 'modal-link',
            'data-title' => 'Авторизация'
        )); ?></li>
        <li class="divider-vertical"></li>
        <li><?= CHtml::link(t('Регистрация'), array('/users/user/registration')); ?></li>
    <? else: ?>
    <li class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle user-menu" href="#"><b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="<?= $this->createUrl('/users/user/view', array('id' => Yii::app()->user->id)) ?>">
                    <?= Yii::app()->user->model->photo_html ?>
                    <b><?= Yii::app()->user->model->name ?></b>
                    <br/>
                    <small class="grey">показать мой профиль</small>
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <?= CHtml::link('<span class="glyphicon-pencil"></span> &nbsp;' . t('Ред. личные данные'),
                array('/users/user/updateSelfData')) ?>
            </li>
            <li class="divider"></li>
            <li>
                <?= CHtml::link(
                '<span class="glyphicon-message-plus"></span> &nbsp;' . t('Личные сообщения'), '') ?>
            </li>
            <li class="divider"></li>
            <li><?= CHtml::link('<span class="glyphicon-new-window"></span> &nbsp;' . t('Выйти'),
                array('/users/user/logout')) ?></li>
        </ul>
    </li>

    <li class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle create-menu" href="#"><b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <?= CHtml::link('<span class="glyphicon-file"></span> &nbsp;' . t('Создать пост'),
                array('/content/page/create')) ?>
            </li>
            <li class="divider"></li>
            <li>
                <?= CHtml::link('<span class="glyphicon-picture"></span> &nbsp;' . t('Фото-альбомы'),
                array('/media/mediaAlbum/userAlbums')) ?>
            </li>
            <li class="divider"></li>
            <li>
                <?= CHtml::link('<span class="glyphicon-facetime-video"></span> &nbsp;' . t('Добавить видео'),
                array('/media/mediaVideo/my')) ?>
            </li>
        </ul>
    </li>
    <? endif ?>
</ul>