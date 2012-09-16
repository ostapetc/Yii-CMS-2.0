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
        $model->model_id  = get_class(Yii::app()->user->model);
        $model->object_id = Yii::app()->user->model->id;

        $form = new Form('media.AlbumForm', $model);
        $this->performAjaxValidation($model);
        if ($form->submitted('submit'))
        {

        }

//        $this->render('create', array('form' => $form));
    }


    public function actionView($id)
    {
        $this->layout     = '//layouts/middle';
        $model            = $this->loadModel($id);
        $this->page_title = 'Альбом: ' . $model->title;
        $form             = new Form('Media.UploadFilesForm', $model);
        $this->render('view', array(
            'model' => $model,
            'form'  => $form
        ));
    }


    public function actionUpload($model_id, $object_id, $tag)
    {
        if ($object_id == 0)
        {
            $object_id = 'tmp_' . Yii::app()->user->id;
        }

        $model            = new MediaFile('insert');
        $model->object_id = $object_id;
        $model->model_id  = $model_id;
        $model->tag       = $tag;

        if ($model->saveFile() && $model->userCanEdit() && $model->save())
        {
            $this->sendFilesAsJson(array($model));
        }
        else
        {
            echo CJSON::encode(array(
                'textStatus' => $model->error
            ));
        }
    }


    public function actionMy()
    {
        $user = User::model()->findByPkOr404(Yii::app()->user->model->id);
        $this->_userAlbums($user, true);
    }


    public function actionUserAlbums($user_id = null)
    {
        if ($user_id == null || Yii::app()->user->model->id == $user_id)
        {
            $this->redirect('my');
        }
        $user = User::model()->findByPkOr404($user_id);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $this->_userAlbums($user);
    }


    protected function _userAlbums($user, $is_my = false)
    {
        $model            = new MediaAlbum(MediaAlbum::SCENARIO_CREATE_USERS);
        $model->model_id  = get_class($user);
        $model->object_id = $user->id;
        $form             = new Form('media.AlbumForm', $model);
        $this->render('userAlbums', array(
            'user'  => $user,
            'form'  => $form,
            'is_my' => $is_my
        ));
    }

}
