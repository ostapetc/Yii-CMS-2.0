<?php
class Sidebar extends BootMenu
{
    public $type = BootMenu::TYPE_LIST;

    public function init()
    {
        $this->items = array(
            array(
                'label'=> 'Начало установки',
            ),
            array(
                'label'=> 'Шаг 1',
            ),
            array(
                'label'=> 'Шаг 2',
            ),
            array(
                'label'=> 'Шаг 3'
            ),
        );

        parent::init();
    }
}