<?

class InstallModule extends WebModule
{
    public static $base_module = true;

    public function getDescription()
    {
        return 'Модуль установки';
    }


    public function getVversion()
    {
        return '0.0.1';
    }


    public function getName()
    {
        return 'Установочный';
    }


    public function init()
    {
        $this->setImport(array(
            'install.models.*', 'install.components.*', 'install.helpers.*'
        ));
    }

    public function routes()
    {
        return array(
            '/install' => 'install/install/index',
        );
    }
}
