<?php

/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 26.09.12
 * Time: 15:57
 * To change this template use File | Settings | File Templates.
 */

class ForumController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            'index' => t('Главная страница форума')
        );
    }


    public function subMenuItems()
    {
        return array(
            array(
                'label' => t('Разделы форума'),
                'url'   => array('/content/forum/index')
            ),
            array(
                'label' => t('Создать топик'),
                'url'   => '/'
            )
        );
    }


    public function actionIndex()
    {
        $this->page_title = '';

        $sections = PageSection::model()->forum()->findAll();

        $this->render('index', array(
            'sections' => $sections
        ));
    }
}
