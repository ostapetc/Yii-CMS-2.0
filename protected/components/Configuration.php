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
        if (strstr($alias, '.') !== false)
        {
            list($module, $config) = explode(".", $alias, 2);
            $module = lcfirst($module);
            return "{$module}.config.{$config}";
        }
        else
        {
            return $alias;
        }
    }


    public function loadFromFile($configFile)
    {
        return parent::loadFromFile($this->getFullAlias($configFile));
    }


    public static function getConfigArray($data = null)
    {
        $c = new static($data);
        return $c->toArray();
    }

}
