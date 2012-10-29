<?
class MediaAlbumController extends ClientController
{
    public $user;


    public static function actionsTitles()
    {
        return [
            "view"        => "Создать",
            "delete"      => "Удалить",
            "update"      => "Редактировать",
            "manage"      => "Управление альбомами",
            "createUsers" => "Создать",
            "manage"      => "Альбомы пользователя",
        ];
    }


    public function subMenuItems()
    {
        return Configuration::getConfigArray('media.submenu');
    }


    public function sidebars()
    {
        return Configuration::getConfigArray('media.fileSidebars');
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
            $this->redirect([
                'view',
                'id' => $model->id
            ]);
        }

        $this->render('createUsers', [
            'user' => $user,
            'form' => $form,
        ]);
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
            $this->sendFilesAsJson([$model]);
        }
        else
        {
            echo CJSON::encode([
                'textStatus' => $model->error
            ]);
        }
    }


    public function actionView($id)
    {
        $model            = MediaAlbum::model()->throw404IfNull()->findByPk($id);
        $this->user       = $model->getParentModel();
        $this->page_title = 'Альбом: ' . $model->title;
        $form             = new Form('Media.UploadFilesForm', $model);
        $dp               = MediaFile::model()->getDataProvider($model, 'files');
        $dp->pagination   = false;

        $this->render('view', [
            'model' => $model,
            'form'  => $form,
            'dp'    => $dp
        ]);
    }


    public function actionManage($user_id = null, $q = null)
    {
        if ($user_id)
        {
            $this->user       = User::model()->throw404IfNull()->findByPk($user_id);
            $this->page_title = 'Альбомы пользователя: ' . $this->user->getLink();
        }
        else
        {
            $this->user       = new User;
            $this->page_title = 'Альбомы';
        }

        $this->render('manage', [
            'dp'    => MediaAlbum::model()->search($this->user, $q),
            'is_my' => Yii::app()->user->id && Yii::app()->user->id == $user_id
        ]);
    }

}
