<?
class ThemeFilter extends CFilter
{

    protected function preFilter($filter_chain)
    {
        if (Yii::app()->params['themes_enabled'])
        {
            $theme_cookie     = Yii::app()->request->cookies['core_theme'];
            $theme            = $theme_cookie ? $theme_cookie->value : null;
            $theme            = Yii::app()->request->getParam('core_theme', $theme);
            Yii::app()->theme = $theme ? $theme : 'basic';
        }
        return true;
    }
}
