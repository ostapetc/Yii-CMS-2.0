<?
/**
 * @property $id
 * @property $name
 * @property $caption
 */
class Sport extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Спорт';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'sports';
    }


    public function rules()
    {
        return array(
            array(
                '',
                'required'
            ),
            array(
                'name, caption',
                'length',
                'max' => 30
             ),

            array(
                'name, caption',
                'unique'
            ),
            array(
                'id',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('caption', $this->caption, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/martialArts/sport/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }
}
