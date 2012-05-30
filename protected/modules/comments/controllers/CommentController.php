<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 30.05.12
 * Time: 20:58
 * To change this template use File | Settings | File Templates.
 */
class CommentController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'create' => 'Добавление комментария'
        );
    }


    public function actionCreate()
    {
        if (Yii::app()->user->isGuest)
        {
            $this->forbidden();
        }

        if (!isset($_POST['Comment']))
        {
            $this->badRequest();
        }

        $c = new Comment();
        $c->text = 'lalal';
        $c->root = 'Page_35';
        $c->saveNode();
        p($c->errors);

//        $comment = new Comment(ActiveRecord::SCENARIO_CREATE);
//        $comment->attributes = $_POST['Comment'];
//        if ($comment->save())
//        {   echo "eee";
//            CJSON::encode(array('done' => true));
//        }
//        else
//        {
//            CJSON::encode(array('error' => true));
//        }
//
//        p($comment->errors);
    }
}
