<?
/**
 * CQueue wrapper to provide system messages different types.
 * Allow types: error|success|info
 * Using Controller:msg to render messages
 *
 * @author Alexey Sharov
 * @version $Id$
 */
require_once(dirname(__FILE__) . '/base/CComponent.php');
require_once(dirname(__FILE__) . '/collections/CQueue.php');

class MsgStream
{
    private $queue;

    private function __construct()
    {
        $this->queue = new CQueue();
    }
    private function __clone() {}
    private function __wakeup() {}

    protected static $_instance;


    const TYPE_ERROR = 'error';
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';

    public function __call($name, $params)
    {
        return call_user_func_array(array($this->queue, $name), $params);
    }

    /**
     * get singleton instance
     *
     * @static
     * @return MessageStream
     */
    public static function getInstance()
    {
        if (!self::$_instance)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Set type to a message item
     *
     * @param mixed $item
     * @param string|null $type error|success|info
     */
    public function enqueue($item, $type = null)
    {
        if (is_array($item))
        {
            $item_array = $item;
        }
        else
        {
            $item_array = array('item'=>$item);
        }
        $item_array['type'] = $type;
        return $this->queue->enqueue($item_array);
    }

    public function render()
    {
        $str = '';
        foreach ($this->queue->toArray() as $item)
        {
            $str .= Yii::app()->controller->msg($item['item'], $item['type']);
        }
        return $str;
    }
}


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
class WebApplication extends CWebApplication {

    /**
     * add error report to MessageStream
     *
     * @param $code
     * @param $message
     * @param $file
     * @param $line
     */
    public function handleError($code,$message,$file,$line)
    {
        if (ENV == 'production')
        {
            $encoding = mb_detect_encoding($message, 'ASCII,WINDOWS-1251');

            $log = $encoding == 'UTF-8' ? $message : @iconv($encoding, 'UTF-8//TRANSLIT//IGNORE', $message);
            MsgStream::getInstance()->enqueue($log, 'error');

            $log .= "code: " . $code . "\n";
            $log .= 'file: ' . $file . "\n" . "line: " . $line . "\n";
            if(isset($_SERVER['REQUEST_URI']))
                $log.='REQUEST_URI='.$_SERVER['REQUEST_URI'];

            Yii::log($log,CLogger::LEVEL_ERROR,'php');
        }
        else
        {
            parent::handleError($code,$message,$file,$line);
        }
    }

    /**
     * add exception report to MessageStream
     *
     * @param Exception $exception
     */
    public function handleException($exception)
    {
        if (ENV == 'production')
        {
            $log = $exception->getMessage();
            MsgStream::getInstance()->enqueue($log, 'error');
            $log .= 'file: ' . $exception->getFile() . "\n" . "line: " . $exception->getLine() . "\n";
            $log .= $exception->getTrace() . "\n";\

            Yii::log($log, CLogger::LEVEL_ERROR);
        }
        else
        {
            parent::handleException($exception);
        }
    }

}



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
