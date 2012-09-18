<?
class MediaModule extends WebModule
{
    public static $active = true;

    public $icon = 'random';

    public function init()
    {
        $this->setImport(array(
            'media.components.*',
            'media.models.*'
        ));
    }

    public function getName()
    {
        return 'Медиа-хранилище';
    }


    public function getDescription()
    {
        return 'Добавляет возможность использования HTML5 загрузчика. Используется для создания своих модулей.';
    }


    public function getVersion()
    {
        return '2.1';
    }


    public function adminMenu()
    {
        return array(
            "Все файлы" => "/media/mediaFileAdmin/manage",
        );
    }

    public function routes()
    {
        return array(
            '/userAlbums/<userId:\d*>' => '/media/mediaAlbum/userAlbums',
            '/media/mediaAlbum/userAlbums/<id:\d*>' => '/media/mediaAlbum/userAlbums',
        );
    }

    public function getFilesDataProvider($model, $tag)
    {
        $file = new MediaFile;
        return new ActiveDataProvider('MediaFile', array(
            'criteria' => $file->parent(get_class($model), $model->getPrimaryKey())->tag($tag)->getDbCriteria(),
        ));
    }


    public function getAlbumsDataProvider($model)
    {
        $file = new MediaFile;
        return new ActiveDataProvider('MediaAlbum', array(
            'criteria' => $file->parent(get_class($model), $model->getPrimaryKey())->getDbCriteria(),
        ));
    }


    public function someFuncName($method, $methodData, $owner = null)
    {
        switch($method){
            case 'album':
                $methodData['model'] = $owner;
                return Yii::app()->controller->widget('media.portlets.ImageGallery', $methodData, true);
                break;
        }
    }
}