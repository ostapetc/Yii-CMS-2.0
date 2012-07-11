<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 17.06.12
 * Time: 21:29
 * To change this template use File | Settings | File Templates.
 */
class UserPagesSidebar extends Portlet
{
    public function renderContent()
    {
        $this->render('UserPagesSidebar', array(
            'widgets'  => PageController::displayWidgets(),
            'widget'   => Yii::app()->request->getParam('widget', 'list'),
            'user_id'  => Yii::app()->request->getParam('user_id'),
            'is_owner' => !Yii::app()->user->isGuest && (Yii::app()->user->id == Yii::app()->request->getParam('user_id'))
        ));
    }
}
