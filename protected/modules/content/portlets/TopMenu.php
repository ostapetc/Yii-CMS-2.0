<?php
class TopMenu extends ClientMenu
{
    const MENU_NAME = 'Верхнее меню';

    public $htmlOptions=array('class'=>'nav');

    public function init()
    {
        parent::init();
        $sections = Menu::model()->findByAttributes(array('name' => self::MENU_NAME))->getSections();
        $i=0;
        foreach ($sections as $item)
        {
            $this->items[] = array(
                'label' => $item->title,
                'url'   => $item->url,
            );
            if (++$i % 3 == 0)
            {
                $this->items[] = array(
                    'label' => '',
                    'itemOptions' => array('class'=>'divider-vertical')
                );

            }
        }
	}
}