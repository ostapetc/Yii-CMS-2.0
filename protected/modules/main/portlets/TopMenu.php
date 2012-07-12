<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 04.07.12
 * Time: 22:06
 * To change this template use File | Settings | File Templates.
 */
class TopMenu extends Portlet
{
    public function renderContent()
    {
        $items = Yii::app()->controller->topMenuItems();

        $this->render('TopMenu', array(
            'items' => $items
        ));
    }
}
