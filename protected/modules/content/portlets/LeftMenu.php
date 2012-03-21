<?php

class LeftMenu extends Portlet
{
    public $left_menu_id;


    public function renderContent()
    {
        if (!is_numeric($this->left_menu_id))
        {
            return;
        }

        $this->render('LeftMenu', array(
            'sections' => Menu::model()->findByPk($this->left_menu_id)->getSections()
        ));
    }
}
