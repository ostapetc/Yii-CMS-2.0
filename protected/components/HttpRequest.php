<?
/**
* Description of HttpRequest
*
*
* Used in config/main.php
* <pre>
 *    'request'=>array(
 *        'class'=>'HttpRequest',
 *        'noCsrfValidationRoutes'=>array(
 *            '^services/wsdl.*$'
 *        ),
 *        'enableCsrfValidation'=>true,
 *        'enableCookieValidation'=>true,
 *    ),
 * </pre>
*
* Every route will be interpreted as a regex pattern.
*/
class HttpRequest extends CHttpRequest
{
    public $prev_url;

    public $noCsrfValidationRoutes = array();


    protected function normalizeRequest()
    {
        parent::normalizeRequest();

        if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] != 'POST')
        {
            return;
        }

        $route = Yii::app()->getUrlManager()->parseUrl($this);
        if($this->enableCsrfValidation)
        {
            foreach($this->noCsrfValidationRoutes as $cr)
            {
                if(preg_match('#'.$cr.'#', $route))
                {
                    Yii::app()->detachEventHandler('onBeginRequest', array($this,'validateCsrfToken'));
                    Yii::trace('Route "'.$route.' passed without CSRF validation');
                    break; // found first route and break
                }
            }
        }
    }

    public function getCurrentUri()
    {
        // Get HTTP/HTTPS (the possible values for this vary from server to server)
        $myUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && !in_array(strtolower($_SERVER['HTTPS']),array('off','no'))) ? 'https' : 'http';
        // Get domain portion
        $myUrl .= '://'.$_SERVER['HTTP_HOST'];
        // Get path to script
        $myUrl .= $_SERVER['REQUEST_URI'];
        // Add path info, if any
//        if (!empty($_SERVER['PATH_INFO'])) $myUrl .= $_SERVER['PATH_INFO'];

        $get = $_GET; // Create a copy of $_GET
        if (count($get)) { // Only add a query string if there's anything left
          $myUrl .= '?'.http_build_query($get);
        }

        return $myUrl;
    }
}
