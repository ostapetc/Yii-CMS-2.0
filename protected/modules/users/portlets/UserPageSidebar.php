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
                'label' => "<span class='glyphicon-file'></span> " . t('Страницы') . ' (' . Yii::app()->user->pages_count . ')',
                'url'   => $this->createUrl(''),
            ),
            array(
                'label' => "<span class='glyphicon-parents'></span> " . t('Друзья') . ' (' . Friend::userFriendsCount(Yii::app()->user->id) . ')',
                'url'   => $this->createUrl('')
            ),
            array(
                'label' => "<span class='glyphicon-star'></span> " . t('Избранное') . ' (' . Yii::app()->user->favorites_count . ')',
                'url'   => $this->createUrl('')
            ),
            array(
                'label' => "<span class='glyphicon-comments'></span> " . t('Комментарии') . ' (' . Yii::app()->user->comments_count . ')',
                'url'   => $this->createUrl('')
            ),
        );

        $title = Yii::app()->request->getParam('id') == Yii::app()->user->id ? t('Ваша инофрмация') : t('Информация о пользователе');

        $this->render('UserPageSidebar', array(
            'items' => $items,
            'title' => $title
        ));
    }
}
