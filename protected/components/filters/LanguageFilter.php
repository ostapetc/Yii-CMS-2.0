<?php
class LanguageFilter extends CFilter
{
    protected function preFilter ($filterChain)
    {
        if (Yii::app()->params['multilanguage_support'] == false)
        {
            return true;
        }

        //set from get params
        if ($lang = Yii::app()->request->getParam('language'))
        {
            Yii::app()->language = $lang;
        }

        Yii::app()->session['language'] = Yii::app()->language;

        if (Yii::app()->request->isPostRequest)
        {
            return true;
        }

        $languages = Language::getCachedArray();

        $url_parts = array_shift(explode('/', Yii::app()->request->getPathInfo()));

        if (!isset($languages[$url_parts ]))
        {
            $filterChain->controller->redirect('/' . Yii::app()->session['language'] . $_SERVER['REQUEST_URI']);
        }

        return true;
    }
}