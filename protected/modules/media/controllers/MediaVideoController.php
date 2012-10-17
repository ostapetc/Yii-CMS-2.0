<?
class MediaVideoController extends ClientController {

    public static function actionsTitles()
    {
        return [
            "manage"    => "Альбомы пользователя",
        ];
    }


    public function subMenuItems()
    {
        return Configuration::getConfigArray('media.submenu');
    }


    public function sidebars()
    {
        return Configuration::getConfigArray('media.videoSidebars');
    }


    public function actionManage($user_id = null)
    {
        if ($user_id === null) {
            $user = null;
        } else {
            $user = User::model()->throw404IfNull()->findByPk($user_id);
            $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        }
        $dp = MediaFile::model()->getDataProvider($user);
        $this->render('userVideos', [
            'model' => $user,
            'is_my' => Yii::app()->user->model->id == $user_id,
            'dp'    => $dp
        ]);
    }
}
