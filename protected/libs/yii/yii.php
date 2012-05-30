<?
require(dirname(__FILE__) . '/YiiBase.php');

/**
 * @method static WebApplication app()
 */
class Yii extends YiiBase
{
    public static function createWebApplication($config=null)
    {
        return self::createApplication('CWebApplication',$config);
    }
}

