<?
class MediaVideoAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return [
            "create"        => "Редактировать",
            "manage"        => "Управление альбомами",
            "localFiles"    => "Управление альбомами",
            "localToRemote" => "Управление альбомами",
        ];
    }


    public function actionLocalFiles($type)
    {
        $file = new MediaFile('search', 'local');
        $file->getDbCriteria()->mergeWith([
            'condition' => 'target_api IS NULL'
        ]);
        $dp = $file->type($type)->getDataProvider();
        $this->render('localVideos', [
            'dp' => $dp
        ]);
    }


    public function actionLocalToRemote($id, $api)
    {
        $file             = MediaFile::model()->findByPk($id);
        $file->target_api = $api;
        $file->save();
    }


    public function actionManage()
    {
        $file  = new MediaFile('search', 'youTube');
        $model = $file->getApi();

        if (isset($_GET[get_class($model)]))
        {
            $model->setAttributes($_GET[get_class($model)], false);
        }

        $this->render('manage', [
            "model" => $model
        ]);
    }

}
