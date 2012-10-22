<?
class MediaVideoController extends ClientController
{


    public $user;


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


    public function actionManage($user_id = null, $q = null)
    {
        if ($user_id === null)
        {
            $this->user = new User;
            $this->page_title = 'Видео';
        }
        else
        {
            $this->user       = User::model()->throw404IfNull()->findByPk($user_id);
            $this->page_title = 'Видео пользователя: ' . $this->user->getLink();
        }

        $file = new MediaFile;
        if ($q)
        {
            $file->getDbCriteria()->compare('title', $q, true);
        }
        $dp = new ActiveDataProvider($file, [
            'criteria' => $file->parentModel($this->user)->type(MediaFile::TYPE_VIDEO)->getDbCriteria(),
            'pagination' => false
        ]);
        $this->render('userVideos', [
            'model' => $this->user,
            'is_my' => Yii::app()->user->id == $user_id,
            'dp'    => $dp,
        ]);
    }
}
