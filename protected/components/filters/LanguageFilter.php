<?
class LanguageFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        $request = Yii::app()->request;

        if ($lang = Yii::app()->request->getParam('language'))
        {
            Yii::app()->language = $lang;
        }

        Yii::app()->session['language'] = Yii::app()->language;

        if (Yii::app()->request->isPostRequest)
        {
            return true;
        }

        $languages = Language::getList();

        $url_parts = explode('/', $_SERVER['REQUEST_URI']);

        if (!isset($languages[$url_parts[1]]))
        {
            $request->redirect('/' . Yii::app()->session['language'] . $_SERVER['REQUEST_URI']);
        }

        return true;
    }
}