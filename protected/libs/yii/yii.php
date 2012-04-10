<?
require(dirname(__FILE__) . '/YiiBase.php');

/**
 * @property CDbMessageSource $messages
 * @method CDbMessageSource getMessages()
 * @property Bootstrap $bootstrap
 * @method Bootstrap getBootstrap()
 * @property AssetManager $assetManager
 * @method AssetManager getAssetManager()
 * @property WebUser $user
 * @method WebUser getUser()
 * @property MetaTags $metaTags
 * @method MetaTags getMetaTags()
 * @property CImageComponent $image
 * @method CImageComponent getImage()
 * @property DaterComponent $dater
 * @method DaterComponent getDater()
 * @property HttpRequest $request
 * @method HttpRequest getRequest()
 * @property UrlManager $urlManager
 * @method UrlManager getUrlManager()
 * @property CDbAuthManager $authManager
 * @method CDbAuthManager getAuthManager()
 * @property CLogRouter $log
 * @method CLogRouter getLog()
 */
class WebApplication extends CWebApplication {}


/**
 * @method static WebApplication app()
 */
class Yii extends YiiBase
{
    public static function createWebApplication($config=null)
    {
        return self::createApplication('WebApplication',$config);
    }
}
