<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 07.06.12
 * Time: 18:47
 * To change this template use File | Settings | File Templates.
 */
class FavoritePortlet extends Portlet
{
    public $model;


    public function init()
    {
        parent::init();

        if (!$this->model instanceof ActiveRecord)
        {
            throw new CException("Параметр model Должен быть объектом класса ActiveRecord");
        }

        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->getModule('social')->assetsUrl() . '/js/favorites.js'
        );
    }


    public function renderContent()
    {
        $object_id = $this->model->id;
        $model_id  = get_class($this->model);

        $count = Favorite::model()->countByAttributes(array(
            'object_id' => $object_id,
            'model_id'  => $model_id
        ));

        $added = false;
        if (!Yii::app()->user->isGuest)
        {
            $added = Favorite::model()->exists("user_id = ". Yii::app()->user->id . " AND object_id = {$object_id} AND model_id = '{$model_id}'");
        }

        $this->render('FavoritePortlet', array(
            'model_id'  => $model_id,
            'object_id' => $object_id,
            'model'     => $this->model,
            'count'     => $count,
            'added'     => $added,
            'guest_msg' => t('Только зарегистрированные пользователи могут добавлять посты в избранное'),
            'user_msg'  => t('Добавить в избранное'),
            'added_msg' => t('Вы уже добавили это в избранное'),
            'count_msg' => t('Количество пользователей, добавивших пост в избранное')
        ));
    }
}
