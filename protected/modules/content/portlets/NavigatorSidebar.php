<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 24.05.12
 * Time: 21:21
 * To change this template use File | Settings | File Templates.
 */
class NavigatorSidebar extends Portlet
{
    public function renderContent()
    {
        $this->render('NavigatorSidebar', [
            'sections' => PageSection::model()->optionsTree()
        ]);
    }
}
