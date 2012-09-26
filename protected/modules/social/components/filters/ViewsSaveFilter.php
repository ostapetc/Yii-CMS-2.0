<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 09.09.12
 * Time: 19:59
 * To change this template use File | Settings | File Templates.
 */

class ViewsSaveFilter extends CFilter
{
    public $model_id;


    public function preFilter($filter_chain)
    {
        if (is_null($this->model_id))
        {
            throw new CException('Required model_id attribute!');
        }

        if (!Yii::app()->user->isGuest && ($id = Yii::app()->request->getParam('id')))
        {
            $attributes = array(
                'user_id'   => Yii::app()->user->id,
                'object_id' => $id,
                'model_id'  => $this->model_id
            );

            $exist = View::model()->existsByAttributes($attributes);

            if (!$exist)
            {
                $view = new View();
                $view->attributes = $attributes;
                if (!$view->save())
                {
                    throw new CException("Can't save views");
                }
            }
        }

        return true;
    }
}
