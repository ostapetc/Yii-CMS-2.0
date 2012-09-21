<?
class MediaModule extends WebModule
{
    public static $active = true;

    public $icon = 'random';

    public function init()
    {
        $this->setImport(array(
            'media.components.*',
            'media.components.YouTube.*',
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
        return '2.3';
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
}