<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 08.09.12
 * Time: 23:44
 * To change this template use File | Settings | File Templates.
 */

class PageInfoSidebar extends Portlet
{
    public function renderContent()
    {
        $this->render('PageInfoSidebar', array(
            'views_count' => View::count('Page', Yii::app()->request->getParam('id'))
        ));
    }
}
