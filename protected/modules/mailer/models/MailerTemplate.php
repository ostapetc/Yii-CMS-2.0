<?

class MailerTemplate extends ActiveRecord
{
    const PAGE_SIZE = 20;

    public $body;


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
        return 'mailer_templates';
    }


    public function rules()
    {
        return array(
            array(
                'name, subject, code',
                'required'
            ),
            array(
                'name, subject',
                'length',
                'max' => 200
            ),
            array(
                'name, code',
                'unique'
            ),
            array(
                'body',
                'safe'
            ),
            array(
                'code',
                'length',
                'max' => 70
            )
        );
    }


    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            array(
                'body' => 'Содержание письма'
            )
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


    public static function getDir()
    {
        return Yii::getPathOfAlias('mailer.views.templates') . DS;
    }


    public function getFilePath()
    {
        return self::getDir() . $this->id . '.html';
    }


    public function afterSave()
    {
        file_put_contents($this->getFilePath(), $this->body);
    }


    public function constructBody(User $user)
    {
        $body = file_get_contents($this->getFilePath());
        $body = $this->replaceMarks($body, $user);
        $body = Yii::app()->text->parseTemplate(
            file_get_contents(Yii::getPathOfAlias('mailer.views.templates') . DS . 'template.html'),
            array(
                'SUBJECT' => $this->subject,
                'BODY' => $body,
            )
        );

        return $body;
    }


    public function constructSubject(User $user)
    {
       return $this->replaceMarks($this->subject, $user);
    }


    public function replaceMarks($text, User $user)
    {
        $params = Param::model()->getValues();
        $params['ACTIVATE_ACCOUNT_HREF'] = Yii::app()->createAbsoluteUrl('/activateAccount/' . $user->activate_code);
        return Yii::app()->text->parseTemplate($text, $params);
    }


    /**
     * Checks for the required templates, use it before code in which they are used
     * @static
     * @param $code
     * @throws CException
     */
    public static function checkRequired($code)
    {
        $code  = trim($code);
        $exist = MailerTemplate::model()->exists("code = '{$code}'");
        if (!$exist)
        {
            throw new CException("Не найден обязательный шаблон письма с кодом: {$code}");
        }
    }
}
