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
            'index' => t('Список бойцов')
        );
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
}
