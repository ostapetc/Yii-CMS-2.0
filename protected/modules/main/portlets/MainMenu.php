<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 03.09.12
 * Time: 14:24
 * To change this template use File | Settings | File Templates.
 */
class MainMenu extends Portlet
{
    public function renderContent()
    {
        $query = "";
        if (isset($_GET['query']))
        {
            $query = trim(strip_tags($_GET['query']));
        }

        $items = array(
            array(
                'label' => t('Посты'),
                'url'   => array('/content/page/index')
            ),
            array(
                'label' => t('Q&A'),
                'url'   => array('/content/qa/index')
            ),
            array(
                'label' => t('Видео'),
                'url'   => array('/media/mediaVideo/manage')
            ),
            array(
                'label' => t('Фото'),
                'url'   => array('/media/mediaAlbum/manage')
            ),
            array(
                'label' => t('Бойцы'),
                'url'   => array('/mma/fighter/index')
            ),
            array(
                'label' => t('Люди'),
                'url'   => array('/users/user/index')
            ),
        );

        $this->render('MainMenu', array(
            'items' => $items,
            'query' => $query
        ));
    }
}
