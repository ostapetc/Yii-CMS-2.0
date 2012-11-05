<?
class MediaModule extends WebModule
{
    public static $active = true;

    public $icon = 'random';

    public function init()
    {
        $this->setImport([
            'media.components.*',
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
        return '2.9';
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
            '/usersAlbums/<user_id:\d*>' => '/media/mediaAlbum/manage',
            '/usersAlbums/' => '/media/mediaAlbum/manage',
            '/album/<id:\d*>' => '/media/mediaAlbum/view',
            '/video/<id:\d*>' => '/media/mediaVideo/view',
            '/usersVideos/<user_id:\d*>' => '/media/mediaVideo/manage',
        ];
    }

    public function getSearchInfo()
    {
        return [
            'files' => [
                'sql' => '
                    SELECT
                        media_files.id,
                        media_files.id as object_id, "MediaFile" as model_id,
                        media_files.title, media_files.descr

                        FROM  ' . MediaFile::model()->tableName() . '
                    ',
            ],
        ];
    }

}