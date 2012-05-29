<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 24.05.12
 * Time: 21:21
 * To change this template use File | Settings | File Templates.
 */
class Navigator extends Portlet
{
    public function renderContent()
    {
        $this->render('Navigator', array(
            'sections' => PageSection::model()->optionsTree()
        ));
    }
}
