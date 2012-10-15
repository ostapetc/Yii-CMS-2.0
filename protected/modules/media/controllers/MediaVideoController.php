<?
class MediaVideoController extends ClientController
{

    public static function actionsTitles()
    {
        return array(
            "userVideos"    => "Альбомы пользователя",
        );
    }


    public function actionUserVideos($user_id = null)
    {
        if ($user_id === null)
        {
            $user_id = Yii::app()->user->model->id;
        }
        $user = User::model()->throw404IfNull()->findByPk($user_id);
//        $a = MediaAlbum::model()->parent(get_class($user), $user->id)->findAll();
//        dump($a);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $dp = MediaAlbum::getDataProvider($user);
        $this->render('userVideos', array(
            'model' => $user,
            'is_my' => Yii::app()->user->model->id == $user_id,
            'dp'    => $dp
        ));
    }
}
