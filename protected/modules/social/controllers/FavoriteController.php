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
            'createOrDelete' => 'Добавление в избранное или удаление из избранного'
        );
    }


    public function actionCreateOrDelete()
    {
        if (!isset($_POST['Favorite']))
        {
            $this->badRequest();
        }

        $response = array();

        $attributes = array(
            'user_id'   => Yii::app()->user->id,
            'object_id' => $_POST['Favorite']['object_id'],
            'model_id'  => $_POST['Favorite']['model_id'],
        );

        $favorite = Favorite::model()->findByAttributes($attributes);

        if ($favorite)
        {
            $response['action'] = 'delete';
            Favorite::model()->deleteAllByAttributes($attributes);
        }
        else
        {
            $response['action'] = 'create';

            $favorite = new Favorite();
            $favorite->attributes = $attributes;
            if (!$favorite->save())
            {
                $response['errors'] = $favorite->errors_flat_array;
            }
        }

        $response['count'] = Favorite::model()->countByAttributes(array(
            'object_id' => $favorite->object_id,
            'model_id'  => $favorite->model_id
        ));

        echo CJSON::encode($response);
    }
}
