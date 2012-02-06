<?php 

class UrlManager extends CUrlManager 
{
    public function createUrl($route, $params)
    {

        $params['language'] = Yii::app()->language;
        return parent::createUrl($route, $params);
    }
}

