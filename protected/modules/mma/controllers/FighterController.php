<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 01.10.12
 * Time: 22:01
 * To change this template use File | Settings | File Templates.
 */

class FighterController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            'index' => t('Список бойцов'),
            'view'  => t('Страница бойца')
        );
    }


    public function subMenuItems()
    {
        return [
            [
                'label' => 'Добавить бойца',
                'url'   => array('/mma/fighter/create')
            ]
        ];
    }


    public function sidebars()
    {
        return [
            [
                'actions'  => ['index'],
                'sidebars' => [
                    [
                        'type'  => 'widget',
                        'class' => 'mma.portlets.FightersFilterSidebar'
                    ],
                ]
            ],
        ];
    }


    public function actionIndex()
    {
        $criteria = new CDbCriteria();

        $fighters = Fighter::model()->findAll(array('limit' => 10));

        $this->render('index', [
            'fighters' => $fighters
        ]);
    }


    public function actionView($url_id)
    {
        $fighter = $this->findFighterByUrlId($url_id);

        $this->render('view', [
            'fighter' => $fighter
        ]);
    }


    public function findFighterByUrlId($url_id)
    {
        $url = explode('-', $url_id);
        $id  = array_pop($url);

        if (!$id)
        {
            $this->pageNotFound();
        }

        $fighter = Fighter::model()->findByPk($id);
        if (!$fighter || ($fighter->url_id != $url_id))
        {
            $this->pageNotFound();
        }

        return $fighter;
    }
}
