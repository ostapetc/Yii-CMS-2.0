<?php

class SiteEnableFilter extends CFilter
{
    protected function preFilter($filter_chain)
    {
        Param::checkRequired(array('SITE_ENABLED'));

        $actions = array('error', 'login');

        if (!Param::getValue('SITE_ENABLED') && Yii::app()->user->role != AuthItem::ROLE_ADMIN && !in_array(Yii::app()->controller->action->id, $actions))
        {
            echo "SITE_OFF";
            //echo PageBlock::getContent('SITE_OFF');
            Yii::app()->end();
        }

        return true;
    }
}
