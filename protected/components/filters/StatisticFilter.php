<?
class StatisticFilter extends CFilter
{
    protected function postFilter($filterChain)
    {
        if (isset(Yii::app()->params['save_site_actions']) && Yii::app()->params['save_site_actions'])
        {
            MainModule::saveSiteAction();
        }

        return true;
    }
}