<table width="100%">
    <tr style="vertical-align: top;">
        <td style="width: 64px; height: 64px;padding-right: 4px;">
            <?= $data->getPhotoHtml(User::PHOTO_SIZE_BIG) ?>
        </td>
        <td>
            <span class="label <?= $data->rating_css_class ?>" style="float: right;">рейтинг <?= $data->rating ?></span>
            <?= $data->link ?> <br/>

            <? if (!Yii::app()->user->isGuest && (Yii::app()->user->id != $data->id)): ?>
                <?
                switch (Friend::getUsersStatus(Yii::app()->user->id, $data->id))
                {
                    case Friend::USERS_STATUS_FRIENDS:
                        $users_status = "<span class='badge badge-success'>" . t('У Вас в друзьях') . "</span>";
                        break;

                    case Friend::USERS_STATUS_NOT_FRIENDS:
                        $users_status = CHtml::button(t('добавить в друзья'), array('class' => 'btn btn-mini add-friend-btn', 'friend_id' => $data->id));
                        break;

                    case Friend::USERS_STATUS_USER_A_WAITING:
                        $users_status = "<span class='badge badge-warning'>" . t('Вы подали заявку в друзья') . "</span>";
                        break;

                    case Friend::USERS_STATUS_USER_B_WAITING:
                        $users_status = "<span class='badge badge-info'>" . t('Подал заявку к вам в друзья') . "</span>";
                        break;
                }
                ?>

                <?= $users_status ?>
            <? endif ?>
        </td>
    </tr>
</table>

<? if ((isset($index) && isset($count)) && ($index + 1) < $count): ?>
    <div class="devider"></div>
<? endif ?>