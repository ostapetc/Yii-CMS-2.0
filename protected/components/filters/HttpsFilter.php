<?php
class HttpsFilter extends CFilter
{
    protected function preFilter ($filterChain)
    {
        if ($filterChain->controller->is_ssl_protected && HTTPS_FILTER_ENABLED) {
            $shouldBeSecureConnection = true;
            $protocoll = 'https://';
        } else {
            $shouldBeSecureConnection = false;
            $protocoll = 'http://';
        }

        if (Yii::app()->getRequest()->isSecureConnection != $shouldBeSecureConnection) {
            $host = array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
            $url = $protocoll . $host . Yii::app()->getRequest()->requestUri;
            Yii::app()->request->redirect($url);
            return false;
        }

        return true;
    }
}