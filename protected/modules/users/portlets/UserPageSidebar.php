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
        $friends_label = "<span class='glyphicon-parents'></span> " . t('Друзья') . ' (' . Friend::userFriendsCount(Yii::app()->user->id) . ')';

        if ($new_friends_count = Friend::userFriendsCount(Yii::app()->user->id, 0))
        {
            $friends_label.= CHtml::link(
                "<span class='badge badge-success'>+" . $new_friends_count . "</span>",
                array('/social/friend/index', 'user_id' => Yii::app()->user->id, 'type' => 'in'),
                array(
                    'title' => t('новые заявки в друзья')
                )
            );
        }

        $items = array(
            array(
                'label' => "<span class='glyphicon-file'></span> " . t('Страницы') . ' (' . Yii::app()->user->pages_count . ')',
                'url'   => $this->createUrl(''),
            ),
            array(
                'label' => $friends_label,
                'url'   => $this->createUrl('/social/friend/index', array('user_id' => Yii::app()->user->id))
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
