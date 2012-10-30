<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 03.09.12
 * Time: 14:24
 * To change this template use File | Settings | File Templates.
 */
class MainMenu extends Portlet
{
    public function renderContent()
    {
        $query = "";
        if (isset($_GET['query']))
        {
            $query = trim(strip_tags($_GET['query']));
        }

        $this->render('Menu', array(
            'items' => Yii::app()->controller->topMenuItems(),
            'query' => $query
        ));
    }
}
