<?
class MediaModule extends WebModule
{
    public static $active = true;

    public $icon = 'random';

    public function init()
    {
        $this->setImport([
            'media.components.*',
            'media.components.YouTube.*',
            'media.models.*'
        ]);
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
        return [
            "Все файлы" => "/media/mediaFileAdmin/manage",
        ];
    }

    public function routes()
    {
        return [
            '/userAlbums/<user_id:\d*>' => '/media/mediaAlbum/manage',
            '/album/<id:\d*>' => '/media/mediaAlbum/view',
            '/video/<user_id:\d*>' => '/media/mediaVideo/manage',
        ];
    }
}