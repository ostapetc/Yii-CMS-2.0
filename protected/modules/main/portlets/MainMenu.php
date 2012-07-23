<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 16.06.12
 * Time: 22:02
 * To change this template use File | Settings | File Templates.
 */
class MainMenu extends Portlet
{
    public function renderContent()
    {
        $items = array(
            array(
                'label' => 'Все страницы',
                'url'   => '/'
            ),
            array(
                'label'   => Yii::app()->user->isGuest ?: 'Мои страницы (' . Page::model()->count('user_id = ' . Yii::app()->user->id) . ')',
                'url'     => array('/page/user/' . Yii::app()->user->id),
                'visible' => !Yii::app()->user->isGuest
            )
        );

        $this->render('MainMenu', array(
            'items' => $items
        ));
    }
}
