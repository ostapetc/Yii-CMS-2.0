<?

abstract class WebModule extends CWebModule
{
    public static $active = true;

    public static $base_module = false;

    protected $_assetsUrl;

    public $icon = 'folder-open';

    public function assetsUrl()
    {
        if ($this->_assetsUrl === null)
        {
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish($this->basePath . '/assets');
        }

        return $this->_assetsUrl;
    }


    public function routes()
    {
        return array();
    }


    public function install(){}


    public function uninstall(){}


    public function adminMenu()
    {
        return array();
    }
}
