<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 07.06.12
 * Time: 19:56
 * To change this template use File | Settings | File Templates.
 */
class FavoriteController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            'create' => 'Добавление в избранное'
        );
    }


    public function actionCreate()
    {
        if (!isset($_POST['Favorite']))
        {
            $this->badRequest();
        }

        $favorite = new Favorite();
        $favorite->attributes = $_POST['Favorite'];
        if ($favorite->save())
        {
            $count = Favorite::model()->countByAttributes(array(
                'object_id' => $favorite->object_id,
                'model_id'  => $favorite->model_id
            ));

            echo CJSON::encode(array('count' => $count));
        }
    }
}
