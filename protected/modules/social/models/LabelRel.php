<?
/**
 * @property $id
 * @property $label_id
 * @property $object_id
 * @property $model_id
 */
class LabelRel extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Связь с ярлыками';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'labels_rels';
    }


    public function rules()
    {
        return array(
            array(
                '',
                'required'
            ),
            array(
                'model_id',
                'length',
                'max' => 50
             ),

            array(
                '',
                'unique'
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
        $criteria->compare('label_id', $this->label_id, true);
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
        return Yii::app()->createUrl('/social/labelrel/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }
}
