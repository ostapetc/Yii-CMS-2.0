<?

class User extends ActiveRecord
{
    const PAGE_SIZE = 20;

    const GENDER_MAN = 'man';
    const GENDER_WOMAN = 'woman';

    const STATUS_ACTIVE = 'active';
    const STATUS_NEW = 'new';
    const STATUS_BLOCKED = 'blocked';

    public static $gender_options = array(
        self::GENDER_MAN => 'man',
        self::GENDER_WOMAN => 'woman',
    );

    public static $status_options = array(
        self::STATUS_ACTIVE => 'active',
        self::STATUS_NEW => 'new',
        self::STATUS_BLOCKED => 'blocked',
    );


    public function name()
    {
        return 'Пользователи';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'users';
    }


    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            array(
                'SortableBehavior' => 'application.extensions.sortable.SortableBehavior',
                'MetaTagBehavior' => 'application.components.activeRecordBehaviors.MetaTagBehavior',
            )
        );
    }


    public function rules()
    {
        return array(
            array(
                'id, first_name, email, password, date_create',
                'required'
            ),
            array(
                'first_name, last_name, patronymic',
                'length',
                'max' => 40
             ),
            array(
                'email',
                'length',
                'max' => 200
             ),
            array(
                'phone',
                'length',
                'max' => 50
             ),
            array(
                'password, activate_code, password_recover_code',
                'length',
                'max' => 32
             ),
            array(
                'gender',
                'in',
                'range' => self::$gender_options
            ),
            array(
                'status',
                'in',
                'range' => self::$status_options
            ),
            array(
                'email',
                'unique'
            ),
            array(
                'phone',
                'PhoneValidator'
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
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('patronymic', $this->patronymic, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('birthdate', $this->birthdate, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('activate_code', $this->activate_code, true);
        $criteria->compare('activate_date', $this->activate_date, true);
        $criteria->compare('password_recover_code', $this->password_recover_code, true);
        $criteria->compare('password_recover_date', $this->password_recover_date, true);
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
        return Yii::app()->createUrl('/mailer/user/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }
}
