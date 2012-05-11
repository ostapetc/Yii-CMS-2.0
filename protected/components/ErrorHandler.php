<?php
class ErrorHandler extends CErrorHandler
{
    public $maintanance = '/maintanance.php';
    public $error404 = '/main/main/error404';

    public function render($view, $data)
    {
        if (ENV == 'production')
        {
            try
            {
                if ($data['type'] == 'CHttpException' && $data['code'] == 404)
                {
                    Yii::app()->runController($this->error404);
                }
                else
                {
                    if ($view == 'exception')
                    {
                        MsgStream::getInstance()->enqueue($data['message'], 'error');
                    }
                    elseif ($view == 'error')
                    {
                        MsgStream::getInstance()->enqueue($data['message'], 'error');
                    }
                    if (!$this->tryRedirectOnPreviousUrl())
                    {
                        Yii::app()->runController($this->errorAction);
                    }
                }
                return true;
            }
            catch(Exception $e)
            {
            }

            MsgStream::getInstance()->clear();
            MsgStream::getInstance()->enqueue($data['message'], 'error');

            $this->redirect($this->maintanance);
        }
        else
        {
            parent::render($view,$data);
        }
    }

    public function redirect($url)
    {

        //check if no content is send
        if (!headers_sent()) {
            header('Location: ' . $url);
        } else {
            //content was already sent
            echo '
                <script type="text/javascript">
                    document.location.href="'.$url.'";
                </script>
                ';
        }

    }

    public function tryRedirectOnPreviousUrl()
    {
        $return_url = Yii::app()->user->getReturnUrl();
        Yii::app()->user->setReturnUrl(false);

        $is_index = $return_url == '/index.php';
        $is_cycle = (!empty($return_url)) && isset($_SERVER['REQUEST_URI']) && ($return_url == $_SERVER['REQUEST_URI']);
        if ($is_index || $is_cycle)
        {
            return false;
        }
        else
        {
            $this->redirect($return_url);
            return true;
        }
    }
}