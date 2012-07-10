<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 01.07.12
 * Time: 23:44
 * To change this template use File | Settings | File Templates.
 */
class UserPageSidebar extends Portlet
{
    public function renderContent()
    {
        $items = array(
            array(
                'label' => t('Страницы') . ' (' . Yii::app()->controller->user->pages_count . ')',
                'url'   => $this->createUrl('')
            ),
            array(
                'label' => t('Друзья') . ' (' . Friend::userFriendsCount(Yii::app()->controller->user->id) . ')',
                'url'   => $this->createUrl('')
            ),
            array(
                'label' => t('Избранное') . ' (' . Yii::app()->controller->user->favorites_count . ')',
                'url'   => $this->createUrl('')
            ),
            array(
                'label' => t('Комментарии') . ' (' . Yii::app()->controller->user->comments_count . ')',
                'url'   => $this->createUrl('')
            ),
        );

        $this->render('UserPageSidebar', array(
            'items' => $items
        ));
    }
}
