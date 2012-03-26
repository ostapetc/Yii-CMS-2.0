<?


abstract class WebModule extends CWebModule {

    public static $active = true;

    public static $base_module = false;

    public static abstract function name();

    public static abstract function description();

    public static abstract function version();

    protected $_assetsUrl;


    public function assetsUrl()
    {
        if ($this->_assetsUrl === null) {
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish($this->basePath . '/assets');
        }

        return $this->_assetsUrl;
    }


    public static function getShortId()
    {
        return strtolower(str_replace('Module', '', get_called_class()));
    }


    public static function routes()
    {
        return array();
    }
}
