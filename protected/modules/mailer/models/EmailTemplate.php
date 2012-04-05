<?

class EmailTemplate extends ActiveRecord
{
    const PAGE_SIZE = 20;


    public function name()
    {
        return 'Шаблоны рассылки';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'email_templates';
    }


    public function rules()
    {
        return array(
            array(
                'id, name, subject, date_create',
                'required'
            ),
            array(
                'name, subject',
                'length',
                'max' => 50
            ),
            array(
                'name',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('subject', $this->subject, true);
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
        return Yii::app()->createUrl('/mailer/emailtemplate/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }
}
