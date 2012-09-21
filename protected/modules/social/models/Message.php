<?

/**
 * @property $id
 * @property $from_user_id
 * @property $to_user_id
 * @property $text
 * @property $is_read
 * @property $date_create
 */

class Message extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Сообщения';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'messages';
    }


    public function rules()
    {
        return array(
            array(
                'from_user_id, to_user_id, text',
                'required'
            ),

            array(
                'id, from_user_id, to_user_id, is_read',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'text',
                'filter',
                'filter' => 'strip_tags'
            )
        );
    }


    public function relations()
    {
        return array(
            'from_user'  => array(
                self::BELONGS_TO,
                'User',
                'from_user_id'
            ),
            'to_user' => array(
                self::BELONGS_TO,
                'User',
                'to_user_id'
            )
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('from_user_id', $this->from_user_id, true);
        $criteria->compare('to_user_id', $this->to_user_id, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('is_read', $this->is_read, true);
        $criteria->compare('date_create', $this->date_create, true);

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
