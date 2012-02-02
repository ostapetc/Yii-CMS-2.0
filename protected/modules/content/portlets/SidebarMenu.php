<?php
class SidebarMenu extends ClientMenu
{
    public $htmlOptions = array(
        'class'=> 'nav nav-list',
        'id'   => 'sidebar-menu'
    );


    public function init()
    {
        $this->items             = array(
            array(
                'label'       => 'Главное',
                'itemOptions' => array('class'=> 'nav-header'),
                'active'      => false,
            ), array(
                'label' => 'Главная',
                'url'   => array('/'),
            ), array(
                'label' => 'Возможности',
                'url'   => array('/'),
            ), array(
                'label' => 'Разработчики',
                'url'   => array('/'),
            ), array(
                'label'       => 'Инструменты',
                'itemOptions' => array('class'=> 'nav-header'),
            ), array(
                'label' => 'Обзор',
                'url'   => array('/'),
            ), array(
                'label' => 'Документация',
                'url'   => array('/'),
            ), array(
                'label'       => 'Будущее',
                'itemOptions' => array('class'=> 'nav-header'),
            ), array(
                'label' => 'Планы на будущее',
                'url'   => array('/'),
            ), array(
                'label' => 'А что еще?',
                'url'   => array('/'),
            ),
        );

        $this->htmlOptions['id'] = 'sidebar-menu';
        $route                   = $this->getController()->getRoute();
        $this->items             = $this->normalizeItems($this->items, $route, $hasActiveChild);
    }

}