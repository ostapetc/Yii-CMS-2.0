<?
class MediaVideoController extends ClientController
{

    public static function actionsTitles()
    {
        return array(
            "userVideos"    => "Альбомы пользователя",
            "my"            => "Мои Альбомы",
        );
    }


    public function actionMy()
    {
        if (Yii::app()->user->isGuest)
        {
            $this->pageNotFound();
        }

        $file = new MediaFile;
        $dp   = $file->getDataProvider(Yii::app()->user->model);
        $this->render('userVideos', array(
            'model' => Yii::app()->user->model,
            'is_my' => true,
            'dp'    => $dp
        ));
    }


    public function actionUserVideos($user_id = null)
    {
        if ($user_id == null || Yii::app()->user->model->id == $user_id)
        {
            $this->redirect(array('my'));
        }
        $user = User::model()->throw404IfNull()->findByPk($user_id);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $dp = MediaAlbum::getDataProvider($user);
        $this->render('userVideos', array(
            'model' => $user,
            'is_my' => false,
            'dp'    => $dp
        ));
    }
}
