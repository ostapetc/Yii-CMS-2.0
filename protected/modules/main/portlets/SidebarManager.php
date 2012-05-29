<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 20.05.12
 * Time: 21:46
 * To change this template use File | Settings | File Templates.
 */
class SidebarManager extends Portlet
{
    public function renderContent()
    {
        if (!method_exists(Yii::app()->controller, 'sidebars')) return;

        $action   = Yii::app()->controller->action->id;
        $sidebars = Yii::app()->controller->sidebars();

        foreach ($sidebars as $data)
        {
            if (!isset($data['actions']) || !isset($data['sidebars']) || !is_array($data['actions']) || !is_array($data['sidebars']))
            {
                continue;
            }

            if (in_array($action, $data['actions']))
            {
                $this->render('SidebarManager', array(
                    'sidebars' => $data['sidebars']
                ));
            }
        }
    }
}
