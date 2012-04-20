<?

class InstallModule extends WebModule
{
    public static $base_module = true;

    public static function description()
    {
        return 'Модуль установки';
    }


    public static function version()
    {
        return '0.0.1';
    }


    public static function name()
    {
        return 'Установочный';
    }


    public function init()
    {
        $this->setImport(array(
            'install.models.*', 'install.components.*',
        ));
    }

    public static function routes()
    {
        return array(
            '/'        => 'install/install/index',
        );
    }
}
