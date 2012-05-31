<?
class FileManagerModule extends WebModule
{
    public static $active = false;

    public function init()
    {
        $this->setImport(array(
            'fileManager.components.*',
            'fileManager.models.*'
        ));
    }


    public static function name()
    {
        return 'Файловый менеджер';
    }


    public static function description()
    {
        return 'Добавляет возможность использования HTML5 загрузчика. Используется для создания своих модулей.';
    }


    public static function version()
    {
        return '2.0';
    }


    public static function adminMenu()
    {
        return array(
            "Все файлы" => "/fileManager/fileManagerAdmin/manage"
        );
    }


    public function getDataProviderByModel($model, $tag)
    {
        $manager = new FileManager();
        return new CActiveDataProvider('FileManager', array(
            'criteria' => $manager->parent(get_class($model), $model->getPrimaryKey())->tag($tag)->dbCriteria,
        ));
    }

    public function getRelation($model, $tag)
    {
        return array(
            CActiveRecord::HAS_MANY,
            'FileManager',
            'object_id',
            'condition' => "$tag.model_id = '" . get_class($model) . "' AND $tag.tag='$tag'",
            'order'     => '$tag.order DESC'
        );
    }
}