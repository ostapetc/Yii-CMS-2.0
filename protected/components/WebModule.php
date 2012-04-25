<?
abstract class WebModule extends CWebModule implements WebModuleInterface
{

    public static $active = true;

    public static $base_module = false;

    protected $_assetsUrl;

    public function assetsUrl()
    {
        if ($this->_assetsUrl === null) {
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish($this->basePath . '/assets');
        }

        return $this->_assetsUrl;
    }


    public static function routes()
    {
        return array();
    }
}
