<?
/**
 * @property $id
 * @property $sherdog_id
 * @property $name
 * @property $date
 */
class MMAEvent extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'MMA событие';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'mma_events';
    }


    public function rules()
    {
        return array(
            array(
                'sherdog_id, name',
                'required'
            ),
            array(
                'name',
                'length',
                'max' => 200
            ),
            array(
                'sherdog_id, name',
                'unique'
            ),
            array(
                'id, sherdog_id',
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
        $criteria->compare('sherdog_id', $this->sherdog_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('date', $this->date, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function uploadFiles()
    {
        return array(
        );
    }
}
