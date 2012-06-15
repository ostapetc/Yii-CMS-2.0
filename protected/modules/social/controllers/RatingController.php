<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 01.06.12
 * Time: 19:18
 * To change this template use File | Settings | File Templates.
 */
class RatingController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'create' => 'Добавление рейтинга'
        );
    }


    public function actionCreate()
    {
        if (!isset($_POST['Rating']))
        {
            $this->badRequest();
        }

        $rating = new Rating();
        $rating->attributes = $_POST['Rating'];
        if ($rating->save())
        {
            $rating = Rating::getValue($rating->model_id, $rating->object_id);
            echo Rating::getHtml($rating);
        }
    }
}
