<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property string $id
 * @property string $user_id
 * @property string $object_id
 * @property string $model_id
 * @property string $date_create
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property        $href
 * @property        $errorsFlatArray
 * @property        $url
 * @property        $updateUrl
 * @property        $createUrl
 * @property        $deleteUrl
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   View   published()
 * @method   View   sitemap()
 * @method   View   ordered()
 * @method   View   last()
 * 
 */

class View extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Просмотры';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'views';
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
                'id, user_id, object_id',
                'numerical',
                'integerOnly' => true
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
        return Yii::app()->createUrl('/social/view/view', array('id' => $this->id));
    }


    public function count($model_id, $object_id = null)
    {
        if ($model_id instanceof ActiveRecord)
        {
            $object_id = $model_id->id;
            $model_id  = get_class($model_id);
        }
        else
        {
            if (!$object_id)
            {
                throw new CException("if first arg not instance of ActiveRecord, you shud set second arg object_id!");
            }
        }

        return self::model()->countByAttributes(array(
            'object_id' => $object_id,
            'model_id'  => $model_id
        ));
    }
}
