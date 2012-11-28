<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 01.06.12
 * Time: 17:33
 * To change this template use File | Settings | File Templates.
 */
class RatingPortlet extends Portlet
{
    public $model;


    public function init()
    {
        parent::init();

        if (!$this->model instanceof ActiveRecord)
        {
            throw new CException("Параметр model Должен быть объектом класса ActiveRecord");
        }

        Yii::app()->clientScript->registerScriptFile('/js/rating/rating.js');
    }


    public function renderContent()
    {
        if (isset($this->model->rating))
        {
            $rating = $this->model->rating;
        }
        else
        {
            $rating = Rating::getValue($this->model);
            $rating = Rating::getHtml($rating);
        }

        $model_id = get_class($this->model);
        $value    = null;

        if (!Yii::app()->user->isGuest)
        {
            $value = Rating::model()->fetchScalarByAttributes(
                array(
                    'user_id'   => Yii::app()->user->id,
                    'object_id' => $this->model->id,
                    'model_id'  => $model_id
                ),
                'value'
            );
        }

        $this->render('RatingPortlet', array(
            'object_id' => $this->model->id,
            'user_id'   => $this->model->getUserId(),
            'model_id'  => $model_id,
            'rating'    => $rating,
            'value'     => $value
        ));
    }
}
