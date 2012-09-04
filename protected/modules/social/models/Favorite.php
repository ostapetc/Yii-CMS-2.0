<?php
/** 
 * @property                 $id
 * @property                 $user_id
 * @property                 $object_id
 * @property                 $model_id
 * @property                 $date_create
 * @property                 $href
 * @property                 $newAttachedModel
 * @property mixed           $related          the related object(s).
 * @property string          $attributeLabel   the attribute label
 * @property CActiveRelation $activeRelation   the named relation declared for this AR class. Null if the relation does not exist.
 * @property mixed           $attribute        the attribute value. Null if the attribute is not set or does not exist.
 * @property string          $error            the error message. Null is returned if no error.
 * @property CList           $eventHandlers    list of attached event handlers for the event
 * 
 */

class Favorite extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Избранное';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'favorites';
    }


    public function rules()
    {
        return array(
            array(
                'user_id, object_id, model_id',
                'required'
            ),
            array(
                'model_id',
                'length',
                'max' => 50
             ),
            array(
                'object_id, model_id', 'filter', 'filter' => 'trim'
            ),
            array(
                'object_id',
                'ObjectExistsValidator'
            ),
            array(
                'user_id',
                'MultiUniqueValidator',
                'unique_attributes' => array(
                    'user_id', 'object_id', 'model_id'
                )
            ),
        );
    }


    public function relations()
    {
        return array(
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('object_id', $this->object_id, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('date_create', $this->date_create, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/social/favorite/view', array('id' => $this->id));
    }
}
