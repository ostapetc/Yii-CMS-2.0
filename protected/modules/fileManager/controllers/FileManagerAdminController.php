<?
//yiicms2@yahoo.com
//yiicms2pass
class FileManagerAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "fileApi.updateAttr"   => "Редактирование файла",
            "fileApi.upload"       => "Загрузка файлов",
            "fileApi.savePriority" => "Сортировка",
            "fileApi.delete"       => "Удаление файла",
            "fileApi.existFiles"   => "Загрузка существующих файлов",
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
