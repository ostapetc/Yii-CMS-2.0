<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 17.09.12
 * Time: 15:23
 * To change this template use File | Settings | File Templates.
 */
class FriendController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            'create' => t('Заявка в друзья')
        );
    }


    public function actionCreate()
    {
        if (!isset($_POST['friend_id']) || Yii::app()->user->isGuest)
        {
            $this->badRequest();
        }

        $user = User::model()->throw404IfNull()->findByPk($_POST['friend_id']);

        $friend = new Friend();
        $friend->user_a_id = Yii::app()->user->id;
        $friend->user_b_id = $user->id;
        if ($friend->save())
        {
            if (isset($_POST['return']) && ($_POST['return'] == 'user_view_item'))
            {
                $this->renderPartial('application.modules.users.views.user._view', array(
                    'data' => $user
                ));
            }
        }
        else
        {
            echo CJSON::encode(array('errors' => $friend->errors_flat_array));
        }
    }
}
