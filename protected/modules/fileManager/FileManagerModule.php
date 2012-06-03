<?
class FileManagerModule extends WebModule
{
    public static $active = true;

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
            "Все файлы" => "/fileManager/fileManagerAdmin/manage",
        );
    }

    public static function routes()
    {
        return array(
            '/userAlbums/<userId:\d*>' => 'fileManager/fileAlbum/userAlbums',
        );
    }

    public function getFilesDataProvider($model, $tag, $config = array())
    {
        $manager = new FileManager();
        return new CActiveDataProvider('FileManager', CMap::mergeArray(array(
            'criteria' => $manager->parent(get_class($model), $model->getPrimaryKey())->tag($tag)->dbCriteria,
        ), $config));
    }


    public function getAlbumsDataProvider($model, $config = array())
    {
        $manager = new FileAlbum();
        return new CActiveDataProvider('FileAlbum', CMap::mergeArray(array(
            'criteria' => $manager->parent(get_class($model), $model->getPrimaryKey())->dbCriteria,
        ), $config));
    }


    public function getAlbumsDataProvider($model)
    {
        $manager = new FileAlbum();
        return new CActiveDataProvider('FileAlbum', array(
            'criteria' => $manager->parent(get_class($model), $model->getPrimaryKey())->dbCriteria,
        ));
    }

}