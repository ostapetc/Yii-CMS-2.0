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

        $this->render('TopMenu', array(
            'sections' => $menu->getSections()
        ));
    }
}
