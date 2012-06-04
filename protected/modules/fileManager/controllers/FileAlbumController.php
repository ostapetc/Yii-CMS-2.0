<?
//yiicms2@yahoo.com
//yiicms2pass
class FileAlbumController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "create" => "Создать",
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
}