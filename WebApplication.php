<?php
/**
 * CQueue wrapper to provide system messages different types.
 * Allow types: error|success|info
 * Using Controller:msg to render messages
 *
 * @author Alexey Sharov
 * @version $Id$
 */
class MsgStream
{
    /**
     * @var CQueue
     */
    private $queue;

    /**
     * Create queue
     */
    private function __construct()
    {
        $this->queue = new CQueue();
    }

    /**
     * private for Singleton
     */
    private function __clone() {}

    /**
     * private for Singleton, prevention creating by serialize
     */
    private function __wakeup() {}

    /**
     * @var self
     */
    protected static $_instance;

    const TYPE_ERROR = 'error';
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';

    /**
     * proxy all calling to CQueue instance
     *
     * @param $name
     * @param $params
     * @return mixed
     */
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
     * Set type item and add to queue
     *
     * @param string $item
     * @param string|null $type error|success|info
     */
    public function enqueue($item, $type = null)
    {
        return $this->queue->enqueue(array(
            'item' => $item,
            'type' => $type
        ));
    }

    /**
     * render all items using Controller::msg method
     *
     * @return string
     */
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
 * @property CommandExecutor $executor
 * @method CommandExecutor getExecutor()
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


    public function initSystemHandlers()
    {
        parent::initSystemHandlers();
        register_shutdown_function(array($this, 'handleShutDown'));
    }

    /**
     * Add error report to MessageStream and logging error
     *
     * Error can came from OS and will using OS default encoding
     * method try to encode it to UTF-8
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
            $encoding = mb_detect_encoding($message, 'ASCII,WINDOWS-1251,UTF-8', true);
            //if no-utf-8 try to encode error message
            $log = $encoding == 'UTF-8' ? $message : @iconv($encoding, 'UTF-8//TRANSLIT//IGNORE', $message);
            MsgStream::getInstance()->enqueue($log, 'error'); //show only message

            //log all
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

    public function handleShutDown()
    {
        $error = error_get_last();
        if ($error != null && isset($error['code'], $error['message'], $error['file'], $error['line']))
        {
            $this->handleError($error['code'], $error['message'], $error['file'], $error['line']);
        }
    }
}

