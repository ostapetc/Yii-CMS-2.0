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
}
