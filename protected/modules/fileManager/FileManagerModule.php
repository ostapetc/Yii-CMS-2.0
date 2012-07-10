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
        return '2.1';
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
            '/userAlbums/<userId:\d*>' => '/fileManager/fileAlbum/userAlbums',
        );
    }

    public function getFilesDataProvider($model, $tag, $config = array())
    {
        $manager = new FileManager();
        $criteria = $manager->parent(get_class($model), $model->getPrimaryKey())->tag($tag)->getDbCriteria();
        if (isset($config['criteria']))
        {
            $criteria->mergeWith($config['criteria']);
            unset($config['criteria']);
        }
        $dep = new CExpressionDependency($manager->max('id'));
//        $dep = new CDbCacheDependency("SELECE MAX(id) FROM file_manager where tag='files' and model_id='FileAlbum' and object_id=18;");
        return new CActiveDataProvider($manager->cache(3600, $dep), CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $config));
    }


    public function getAlbumsDataProvider($model, $config = array())
    {
        $manager = new FileAlbum();
        $criteria = $manager->parent(get_class($model), $model->getPrimaryKey())->getDbCriteria();
        if (isset($config['criteria']))
        {
            $criteria->mergeWith($config['criteria']);
            unset($config['criteria']);
        }
//        $dep = new CDbCacheDependency("SELECE MAX(id) FROM file_manager where tag='files' and model_id='FileAlbum' and object_id=18;");
        $dep = new CExpressionDependency($manager->max('id'));

        return new CActiveDataProvider($manager->cache(3600,$dep), CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $config));
    }

}