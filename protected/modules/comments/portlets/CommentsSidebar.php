<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 21.06.12
 * Time: 19:36
 * To change this template use File | Settings | File Templates.
 */
class CommentsSidebar extends Portlet
{
    public function renderContent()
    {
        $this->render('CommentsSidebar', array(
            'comments_list' => array(
                t('Свежие комментарии')   => Comment::model()->last()->limit(7)->findAll(),
                t('Рейтовые комментарии') => Comment::model()->last()->limit(7)->findAll()
            )
        ));
    }
}
