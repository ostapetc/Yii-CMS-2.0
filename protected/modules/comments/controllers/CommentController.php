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
            'create' => 'Добавление комментария',
            'list'   => 'Список комментариев'
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

        $comment = new Comment(ActiveRecord::SCENARIO_CREATE);
        $comment->attributes = $_POST['Comment'];
        if ($comment->validate())
        {
//            $root = Comment::model()->findByAttributes(
//                array('object' => $comment->object),
//                array('order'  => '`left`')
//            );

            //if ($root)
            //{
                if (isset($_POST['Comment']['parent_id']) && is_numeric($_POST['Comment']['parent_id']))
                {
                    $root = Comment::model()->findByPk($_POST['Comment']['parent_id']);
                    $comment->appendTo($root);
                }


            //}
            else
            {
                $comment->saveNode();
            }
        }
    }


    public function actionList($object)
    {
        $this->layout = false;

        $criteria = new CDbCriteria();
        $criteria->compare('object', $object);
        $criteria->order = '`root`, `left`';
        $criteria->with  = array('user');

        $comments = Comment::model()->findAll($criteria);

        $this->render('list', array(
            'comments' => $comments
        ));
    }
}
