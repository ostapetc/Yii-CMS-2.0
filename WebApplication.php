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
        $this->queue = new CQueue(Yii::app()->session->get('core_messages', array()));
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
        $result = call_user_func_array(array($this->queue, $name), $params);
        Yii::app()->getSession()->add('core_messages', $this->queue->toArray());
        return $result;
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
        $result = $this->queue->enqueue(array(
            'item' => $item,
            'type' => $type
        ));
        Yii::app()->getSession()->add('core_messages', $this->queue->toArray());
        return $result;
    }

    /**
     * render all items using Controller::msg method
     *
     * @return string
     */
    public function render($clear = true)
    {
        $str = '';
        foreach ($this->queue->toArray() as $item)
        {
            $str .= Yii::app()->controller->msg($item['item'], $item['type']);
        }
        $this->clear();
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

    public function displayError($code, $message, $file, $line)
    {
        if (ENV == 'production')
        {
            $encoding = mb_detect_encoding($message, 'ASCII,WINDOWS-1251,UTF-8', true);
            //if no-utf-8 try to encode error message
            $log = $encoding == 'UTF-8' ? $message : @iconv($encoding, 'UTF-8//TRANSLIT//IGNORE', $message);
            MsgStream::getInstance()->enqueue($log, MsgStream::TYPE_ERROR); //show only message
        }
        else
        {
            parent::displayError($code, $message, $file, $line);
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

