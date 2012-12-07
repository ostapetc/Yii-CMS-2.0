<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 01.06.12
 * Time: 19:18
 * To change this template use File | Settings | File Templates.
 */
class RatingController extends ClientController
{
    public function accessRules()
    {
        return [
            ['allow', 'actions' => ['create'], 'users' => ['user']],
            ['deny',  'actions' => ['create'], 'users' => ['*']]
        ];
    }


    public static function actionsTitles()
    {
        return ['create' => 'Добавление рейтинга'];
    }


    public function actionCreate()
    {
        if (!isset($_POST['Rating']))
        {
            $this->badRequest();
        }

        $rating = Rating::model()->findByAttributes(array(
            'user_id'   => Yii::app()->user->id,
            'object_id' => $_POST['Rating']['object_id'],
            'model_id'  => $_POST['Rating']['model_id']
        ));

        if (!$rating)
        {
            $rating = new Rating();
        }

        $rating->attributes = $_POST['Rating'];

        if ($rating->save())
        {
            $rating = Rating::getValue($rating->model_id, $rating->object_id);
            echo Rating::getHtml($rating);
        }
        else
        {
            echo CJSON::encode(array('errors' => $rating->errors_flat_array));
        }
    }
}
