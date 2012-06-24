<?

class User extends ActiveRecord
{
    const PAGE_SIZE = 10;

    const PHOTO_PATH = 'upload/photo';

    const STATUS_ACTIVE  = 'active';
    const STATUS_NEW     = 'new';
    const STATUS_BLOCKED = 'blocked';

    const GENDER_MAN   = "man";
    const GENDER_WOMAN = "woman";

    const SCENARIO_CHANGE_PASSWORD_REQUEST = 'ChangePasswordRequest';
    const SCENARIO_ACTIVATE_REQUEST        = 'ActivateRequest';
    const SCENARIO_CHANGE_PASSWORD         = 'ChangePassword';
    const SCENARIO_REGISTRATION            = 'Registration';
    const SCENARIO_UPDATE                  = 'Update';
    const SCENARIO_CREATE                  = 'Create';
    const SCENARIO_LOGIN                   = 'Login';
    const SCENARIO_CABINET                 = 'Cabinet';


    public $password_c;

    public $remember_me = false;

    public $activate_error;

    public $activate_code;


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


    public static $status_options = array(
        self::STATUS_ACTIVE  => "Активный",
        self::STATUS_NEW     => "Новый",
        self::STATUS_BLOCKED => "Заблокирован"
    );


    public static $gender_options = array(
        self::GENDER_MAN   => "Мужской",
        self::GENDER_WOMAN => "Женский"
    );


    public function getUserDir()
    {
        $dir  = "upload/users/".$this->id."/";
        $path = $_SERVER["DOCUMENT_ROOT"].$dir;

        if (!file_exists($path))
        {
            mkdir($path);
            chmod($path, 0777);
        }

        return $dir;
    }


    public function rules()
    {
        return array(
//            array(
//                'captcha',
//                'captcha',
//                'on' => array(
//                    self::SCENARIO_REGISTRATION,
//                    self::SCENARIO_ACTIVATE_REQUEST,
//                    self::SCENARIO_CHANGE_PASSWORD_REQUEST,
//                ),
//            ),
            array(
                'email',
                'required',
                'on' => array(
                    self::SCENARIO_ACTIVATE_REQUEST,
                    self::SCENARIO_CHANGE_PASSWORD_REQUEST,
                    self::SCENARIO_CREATE,
                    self::SCENARIO_LOGIN,
                    self::SCENARIO_REGISTRATION,
                    self::SCENARIO_UPDATE
                )
            ),
            array(
                'name',
                'required',
                'on' => array(self::SCENARIO_REGISTRATION)
            ),
            array(
                'name',
                'length',
                'max' => 40
            ),
            array(
                'photo', 'safe', 'on' => array(
                    self::SCENARIO_CREATE,
                    self::SCENARIO_REGISTRATION,
                    self::SCENARIO_CABINET,
                    self::SCENARIO_UPDATE
                )
            ),
            array(
                'name',
                'RuLatAlphaValidator'
            ),
    //            array(
    //                'gender',
    //                'required',
    //                'on' => array(self::SCENARIO_REGISTRATION)
    //            ),
            array(
                'password_c, password',
                'required',
                'on' => array(
                    self::SCENARIO_REGISTRATION,
                    self::SCENARIO_CHANGE_PASSWORD,
                    self::SCENARIO_UPDATE,
                    self::SCENARIO_CREATE
                )
            ),

            array(
                'password',
                'required',
                'on' => array(
                    self::SCENARIO_LOGIN,
                    self::SCENARIO_REGISTRATION,
                )
            ),
            array(
                'password',
                'length',
                'min' => 6,
                'on'  => array(
                    self::SCENARIO_REGISTRATION,
                    self::SCENARIO_CHANGE_PASSWORD,
                    self::SCENARIO_UPDATE,
                    self::SCENARIO_CREATE
                )
            ),
            array(
                'email',
                'email'
            ),
            array(
                'email',
                'unique',
                'attributeName' => 'email',
                'className'     => 'User',
                'on'            => self::SCENARIO_REGISTRATION
            ),
            array(
                'password_c',
                'compare',
                'compareAttribute' => 'password',
                'on'               => array(
                    self::SCENARIO_REGISTRATION,
                    self::SCENARIO_CHANGE_PASSWORD,
                    self::SCENARIO_UPDATE,
                    self::SCENARIO_CREATE
                )
            ),
            //array(
            //    'birthdate',
            //    'date',
            //    'format'  => 'dd.mm.yyyy',
            //    'message' => 'Верный формат даты (дд.мм.гггг) используйте календарь.',
            //    'on'      => self::SCENARIO_REGISTRATION
            //),
            array(
                'name',
                'length',
                'min' => 2
            ),
            array(
                'email',
                'length',
                'max' => 200
            ),
            array(
                'gender',
                'in',
                'range' => array_keys(self::$gender_options)
            ),
            array(
                'status',
                'in',
                'range' => array_keys(self::$status_options)
            ),
            array(
                'email',
                'filter',
                'filter' => 'trim'
            ),
            array(
                'id, email, birthdate, gender, status, date_create',
                'safe',
                'on'=> self::SCENARIO_SEARCH
            ),
            array(
                'activate_date',
                'safe',
                'on' => self::SCENARIO_ACTIVATE_REQUEST
            ),
            array(
                'rating',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'rating', 'unsafe'
            )
        );
    }


    public function relations()
    {
        return array(
            'file_albums' => array(
                self::HAS_MANY ,
                'FileAlbum',
                'object_id',
                'condition' => "file_albums.model_id = '".get_class($this)."'"
            ),
            'file_albums_count' => array(
                self::STAT ,
                'FileAlbum',
                'object_id',
                'condition' => "t.model_id = '".get_class($this)."'"
            ),
            'assignment' => array(
                self::HAS_ONE,
                'AuthAssignment',
                'userid'
            ),
            'role'       => array(
                self::HAS_ONE,
                'AuthItem',
                array('itemname'=>'name'),
                'through' => 'assignment'
            )
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('birthdate', $this->birthdate, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('date_create', $this->date_create, true);
        $criteria->with = 'role';

        return new ActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort'     => array(
                'attributes' => array(
                    'role' => array(
                        'asc'  => 'role.name',
                        'desc' => 'role.name DESC'
                    ),
                    '*'
                )
            )
        ));
    }


    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
                "password_c"   => "Пароль еще раз",
                "remember_me"  => "Запомни меня",
                "role"         => "Роль"
            ));
    }


    public function generateActivateCode()
    {
        $this->activate_code = md5($this->id . $this->name . $this->email . time(true) . rand(5, 10));
        return $this->activate_code;
    }


    public function getRole()
    {
        $assigment = AuthAssignment::model()->findByAttributes(array(
            'userid' => $this->id
        ));

        if (!$assigment)
        {
            $assigment = new AuthAssignment();
            $assigment->itemname = AuthItem::ROLE_DEFAULT;
            $assigment->userid   = $this->id;
            $assigment->save();
        }

        return $assigment->role;
    }


    public function isRootRole()
    {
        return $this->role->name == AuthItem::ROLE_ROOT;
    }


    public function getPhotoLink()
    {
        $photo_src = '/img/icons/user.gif';
        $image     =  CHtml::image($photo_src, $this->name, array('title' => $this->name, 'border' => 0));

        return CHtml::link($image, $this->href, array('class' => 'user-photo-link', 'width' => '23', 'height' => '23'));
    }

    public function uploadFiles()
    {
        return array(
            'photo' => array(
                'dir' => self::PHOTO_PATH
            )
        );
    }

    public function getLink()
    {
        return CHtml::link(
            $this->name,
            $this->href,
            array('class' => 'user-link')
        );
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/user/' . $this->id);
    }

}

