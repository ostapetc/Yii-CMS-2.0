<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 13.07.12
 * Time: 15:02
 * To change this template use File | Settings | File Templates.
 */
class TaskController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            'allow' => t('Установка доступа для роли')
        );
    }


    public function actionAllow($item_name)
    {

    }
}
