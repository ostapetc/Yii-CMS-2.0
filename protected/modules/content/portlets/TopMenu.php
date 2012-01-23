<?php

class TopMenu extends Portlet
{	
	const MENU_NAME = 'Верхнее меню';

	public function renderContent()
	{
        $sections = Menu::model()->findByAttributes(array('name' => self::MENU_NAME))
                                 ->getSections();

		$this->render('TopMenu', array('sections' => $sections));
	}
}