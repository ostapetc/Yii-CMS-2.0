<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 29.01.12
 * Time: 23:21
 * To change this template use File | Settings | File Templates.
 */
class AdminMenu extends Portlet
{
    public function renderContent()
    {
        $this->render('AdminMenu', array(
            'modules' => AppManager::getModulesData(true, true)
        ));
    }
}
