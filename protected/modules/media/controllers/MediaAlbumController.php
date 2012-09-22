<?
class MediaAlbumController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            "createUsers"      => "Создать",
            "view"             => "Создать",
            "delete"           => "Удалить",
            "update"           => "Редактировать",
            "manage"           => "Управление альбомами",
            "userAlbums"       => "Альбомы пользователя",
            "my"               => "Мои Альбомы",
        );
    }


    public function actionCreateUsers()
    {
        $model            = new MediaAlbum(MediaAlbum::SCENARIO_CREATE_USERS);
        $user             = Yii::app()->user->model;
        $model->model_id  = get_class($user);
        $model->object_id = $user->id;

        $form = new Form('media.AlbumForm', $model);
        $this->performAjaxValidation($model);
        if ($form->submitted() && $model->save())
        {
            $this->redirect(array('my'));
        }

        $this->render('createUsers', array(
            'user'  => $user,
            'form'  => $form,
        ));
    }


    public function actionView($id)
    {
        $model            = MediaAlbum::model()->throw404IfNull()->findByPk($id);
        $this->page_title = 'Альбом: ' . $model->title;
        $form             = new Form('Media.UploadFilesForm', $model);

        $dp               = MediaFile::getDataProvider($model, 'files');
        $dp->pagination   = false;

        $this->render('view', array(
            'model' => $model,
            'form'  => $form,
            'dp' => $dp
        ));
    }

    public function actionMy()
    {
        if (Yii::app()->user->isGuest)
        {
            $this->pageNotFound();
        }
        $dp = MediaAlbum::getDataProvider(Yii::app()->user->model);
        $this->render('userAlbums', array('user' => Yii::app()->user->model, 'is_my' => true, 'dp' => $dp));
    }

    public function actionUserAlbums($user_id = null)
    {
        if ($user_id == null || Yii::app()->user->model->id == $user_id)
        {
            $this->redirect(array('my'));
        }
        $user             = User::model()->throw404IfNull()->findByPk($user_id);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $dp               = MediaAlbum::getDataProvider($user);
        $this->render('userAlbums', array('user' => $user, 'is_my' => false, 'dp' => $dp));
    }



}
