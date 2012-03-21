<?php

class TopMenu extends Portlet
{
    const CODE = "TOP_MENU";


    public function renderContent()
    {
        $menu = Menu::model()->language()->published()->find("code = '" . self::CODE . "'");
        if (!$menu)
        {
            return;
        }

        if ($menu->current_section && !Yii::app()->controller->left_menu_id)
        {
            Yii::app()->controller->left_menu_id = $menu->current_section->left_menu_id;
        }

        $this->render('TopMenu', array(
            'sections' => $menu->getSections()
        ));
    }
}
