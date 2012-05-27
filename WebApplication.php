<?php
/**
 * CQueue wrapper to provide system messages different types.
 * Allow types: error|success|info
 * Using Controller:msg to render messages
 *
 * @author Alexey Sharov
 * @version $Id$
 */
class MsgStream extends SplQueue
{
    /**
     * Create queue
     */
    private function __construct()
    {
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
     * proxy all calling to Spl*Queue instance
     *
     * @param $name
     * @param $params
     * @return mixed
     */
    public function __call($name, $params)
    {
        $result = parent::$name($params);
        Yii::app()->getSession()->add('core_messages', iterator_to_array($this));
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
        $result = parent::enqueue(array(
            'item' => $item,
            'type' => $type
        ));
        Yii::app()->getSession()->add('core_messages', iterator_to_array($this));
        return $result;
    }

    public function clear()
    {
        $this->setIteratorMode(SplQueue::IT_MODE_DELETE); //need clear???
        iterator_to_array($this);
        $this->setIteratorMode(SplQueue::IT_MODE_KEEP); //need clear???
    }

    /**
     * render all items using Controller::msg method
     *
     * @return string
     */
    public function render($clear = false)
    {
        $str = '';
        if ($clear)
        {
            $this->setIteratorMode(SplQueue::IT_MODE_DELETE); //need clear???
        }
        foreach ($this as $item)
        {
            $str .= Yii::app()->controller->msg($item['item'], $item['type']);
        }
        $this->setIteratorMode(SplQueue::IT_MODE_KEEP);
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

    public function handleShutDown()
    {
        $error = error_get_last();
        if ($error != null && isset($error['code'], $error['message'], $error['file'], $error['line']))
        {
            $this->handleError($error['code'], $error['message'], $error['file'], $error['line']);
        }
    }
}

