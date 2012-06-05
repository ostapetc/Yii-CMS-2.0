<?
//yiicms2@yahoo.com
//yiicms2pass
class FileAlbumController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            "create" => "Создать",
            "view" => "Создать",
            "delete" => "Удалить",
            "update" => "Редактировать",
            "manage" => "Управление альбомами"
        );
    }

    public function actionCreate()
    {
        $model = new FileAlbum;
        $form = new Form('FileManager.AlbumForm', $model);

        if ($form->submitted('submit') && !$model->validate())
        {
            $this->performAjaxValidation($model);
        }
        $model->save(false);
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $form = new Form('FileManager.UploadFilesForm', $model);
        $this->render('view', array('model' => $model, 'form' => $form));
    }

    public function actionUpload($model_id, $object_id, $tag)
    {
        if ($object_id == 0)
        {
            $object_id = 'tmp_' . Yii::app()->user->id;
        }

        $model            = new FileManager('insert');
        $model->object_id = $object_id;
        $model->model_id  = $model_id;
        $model->tag       = $tag;

        if ($model->saveFile() && $model->save())
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

}
