<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 22.12.12
 * Time: 14:12
 * To change this template use File | Settings | File Templates.
 */

class TagsSidebar extends Portlet
{
    public function renderContent()
    {
        $tags = Tag::model()->findAll();
        $this->render(__CLASS__, ['tags' => $tags]);
    }
}
