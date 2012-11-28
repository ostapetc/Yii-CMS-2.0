<?php

/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 20.09.12
 * Time: 17:50
 * To change this template use File | Settings | File Templates.
 */

class MessageDialogsSidebar extends Portlet
{
    public function renderContent()
    {
        $user_id = Yii::app()->user->id;

        $sql = "SELECT DISTINCT users.id
                       FROM users
                       INNER JOIN messages
                               ON (messages.to_user_id = {$user_id} OR messages.from_user_id = {$user_id})
                       ORDER BY messages.date_create";

        $users_ids = Yii::app()->db->createCommand($sql)->queryAll();
        $users_ids = ArrayHelper::extract($users_ids, 'id');

        $this->render('MessageDialogsSidebar', array(
            'users' => User::model()->findAllByPk($users_ids)
        ));
    }
}
