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
                'label'       => t('Главное'),
                'itemOptions' => array('class'=> 'nav-header'),
                'active'      => false,
            ), array(
                'label' => t('Главная'),
                'url'   => array('/'),
            ), array(
                'label' => t('Новости'),
                'url'   => array('/news/news/index'),
            ), array(
                'label' => t('Разработчики'),
                'url'   => array('/'),
            ), array(
                'label'       => t('Инструменты'),
                'itemOptions' => array('class'=> 'nav-header'),
            ), array(
                'label' => t('Обзор'),
                'url'   => array('/'),
            ), array(
                'label' => t('Документация'),
                'url'   => array('/doc/conventions/naming'),
            ),
        );

        $this->htmlOptions['id'] = 'sidebar-menu';
        $route                   = $this->getController()->getRoute();
        $this->items             = $this->normalizeItems($this->items, $route, $hasActiveChild);
    }

}