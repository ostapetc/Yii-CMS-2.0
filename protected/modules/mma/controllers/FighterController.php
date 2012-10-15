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


    public function actionIndex()
    {
        $criteria = new CDbCriteria();

        $data_provider = new CActiveDataProvider('Fighter', array(
            'criteria'   => $criteria,
            'pagination' => array(
                'pageSize' => 15
            )
        ));

        $this->render('index', array(
            'data_provider' => $data_provider,
        ));
    }
}
