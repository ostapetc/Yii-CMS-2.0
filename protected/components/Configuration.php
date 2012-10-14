<?
class Configuration extends CConfiguration
{
    public function __construct($data = null)
    {
        if (is_string($data) && strpos($data, '.') !== false)
        {
            $data = Yii::getPathOfAlias(self::getFullAlias($data)) . '.php';
        }
        return parent::__construct($data);
    }


    public static function getFullAlias($alias)
    {
        list($module, $config) = explode(".", $alias, 2);
        $module = lcfirst($module);
        return "{$module}.config.{$config}";
    }

}
