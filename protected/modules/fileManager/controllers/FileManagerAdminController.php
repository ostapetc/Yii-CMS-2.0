<?
//yiicms2@yahoo.com
//yiicms2pass
class FileManagerAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "delete"   => "Удаление файла",
        );
    }


    public function actions()
    {
        return array(
            'fileApi.' => 'fileManager.components.FileApiActionProvider',
        );
    }


    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
    }


    public function actionUpdateAttr($id)
    {
    }


}
