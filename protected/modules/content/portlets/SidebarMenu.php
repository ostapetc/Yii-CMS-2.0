<?php
class SidebarMenu extends ClientMenu
{
    public $htmlOptions = array('class'=> 'nav nav-list');


    public function init()
    {
        parent::init();

        $this->items = array(
            array(
                'label'       => 'Sidebar',
                'itemOptions' => array('class'=> 'nav-header'),
                'active'      => false,
            ), array(
                'label' => 'Link',
                'url'   => array('/'),
                'active'=> true,
            ), array(
                'label' => 'Link',
                'url'   => array('/'),
                'active'=> false,
            ), array(
                'label'       => 'Sidebar',
                'itemOptions' => array('class'=> 'nav-header'),
                'active'      => false,
            ), array(
                'label' => 'Link',
                'url'   => array('/'),
                'active'=> false,
            ), array(
                'label' => 'Link',
                'url'   => array('/'),
                'active'=> false,
            ), array(
                'label'       => 'Sidebar',
                'itemOptions' => array('class'=> 'nav-header'),
                'active'      => false,
            ), array(
                'label' => 'Link',
                'url'   => array('/'),
                'active'=> false,
            ), array(
                'label' => 'Link',
                'url'   => array('/'),
                'active'=> false,
            ),
        );
    }

}