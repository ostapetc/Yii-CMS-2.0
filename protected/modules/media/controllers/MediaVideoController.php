<?
class MediaVideoController extends ClientController {

    public static function actionsTitles()
    {
        return array(
            "create"        => "Добавление Видео",
            "manage"        => "Управление альбомами",
            "createUsers"   => "Создать",
            "userVideos"    => "Альбомы пользователя",
            "my"            => "Мои Альбомы",
        );
    }


    public function actionCreate()
    {
        $user = Yii::app()->user->model;
        $this->render('create', array('model' => $user));
    }


    public function actionManage()
    {
        $file = new MediaFile('search', 'youTube');
        $model = $file->getApi();

        if (isset($_GET[get_class($model)])) {
            $model->setAttributes($_GET[get_class($model)], false);
        }

        $this->render('manage', array(
            "model" => $model
        ));
    }

    public function actionMy()
    {
        if (Yii::app()->user->isGuest) {
            $this->pageNotFound();
        }
        $dp = MediaAlbum::getDataProvider(Yii::app()->user->model);
        $this->render('userAlbums', array('model' => Yii::app()->user->model, 'is_my' => true, 'dp' => $dp));
    }

    public function actionUserVideos($user_id = null)
    {
        if ($user_id == null || Yii::app()->user->model->id == $user_id) {
            $this->redirect(array('my'));
        }
        $user = User::model()->throw404IfNull()->findByPk($user_id);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $dp = MediaAlbum::getDataProvider($user);
        $this->render('userAlbums', array('model' => $user, 'is_my' => false, 'dp' => $dp));
    }
}
