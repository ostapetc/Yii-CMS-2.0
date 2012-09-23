<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property string   $id
 * @property string   $sport_id
 * @property string   $object_id
 * @property string   $model_id
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property          $href
 * @property          $errorsFlatArray
 * @property          $url
 * @property          $updateUrl
 * @property          $createUrl
 * @property          $deleteUrl
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   SportRel published()
 * @method   SportRel sitemap()
 * @method   SportRel ordered()
 * @method   SportRel last()
 * 
 */

class SportRel extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Sport Relation';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'sports_rels';
    }


    public function rules()
    {
        return array(
            array(
                'sport_id, object_id, model_id',
                'required'
            ),
            array(
                'model_id',
                'length',
                'max' => 50
             ),

            array(
                'id, sport_id, object_id',
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
        $criteria->compare('sport_id', $this->sport_id, true);
        $criteria->compare('object_id', $this->object_id, true);
        $criteria->compare('model_id', $this->model_id, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/martialArts/sportrel/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }


    public function getSportsIds(ActiveRecord $model)
    {
        $sql = "SELECT sport_id
                       FROM " . $this->tableName() . "
                       WHERE object_id = " . $model->id . " AND
                             model_id  = '" . get_class($model) . "'";

        return Yii::app()->db->createCommand($sql)->queryColumn();
    }
}
