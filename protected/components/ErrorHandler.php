<?php
Yii::import('system.base.CErrorHandler', true);

class ErrorHandler extends CErrorHandler
{
    public $maintanance = '/maintanance.php';
    public $error404 = '/main/main/error404';

    public function render($view, $data)
    {
        if (CONFIG == 'production')
        {
            try
            {
                if ($data['type'] == 'CHttpException' && $data['code'] == 404)
                {
                    Yii::app()->runController($this->error404);
                    return true;
                }
                if ($view == 'exception' || $view == 'error')
                {
                    Yii::app()->user->setFlash('error', $data['message']);
                }
                $this->tryRedirectOnPreviousUrl();
            }
            catch(Exception $e)
            {
                Yii::log($e->getTraceAsString(), CLogger::LEVEL_ERROR);
            }

            Yii::app()->user->setFlash('error', $data['message']);

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
        if ($return_url === false || $is_index || $is_cycle)
        {
            throw new CException("Can't redirect back");
        }
        else
        {
            $this->redirect($return_url);
        }
    }
}