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
                'name, subject',
                'required'
            ),
            array(
                'name, subject',
                'length',
                'max' => 200
            ),
            array(
                'name',
                'unique'
            ),
            array(
                'body',
                'safe'
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
        return Yii::getPathOfAlias('application.modules.mailer.views.emailTemplates') . DS;
    }


    public function getFilePath()
    {
        return self::getDir() . $this->id . '.html';
    }


    public function afterSave()
    {
        file_put_contents($this->getFilePath(), $this->body);
    }


    public function compiledBody(User $user)
    {
        $body = file_get_contents($this->getFilePath());
        $body = str_replace(
            array(
                '{{ACTIVATE_ACCOUNT_HREF}}'
            ),
            array(
                Yii::app()->createAbsoluteUrl('/activateAccount/' . $user->generateActivateCode())
            ),
            $body
        );

        $template = file_get_contents(Yii::getPathOfAlias('application.modules.mailer.views.emailTemplates') . DS . 'template.html');
        $template = str_replace(
            array(
                '{{SUBJECT}}',
                '{{BODY}}',
                '{{}}'
            ),
            array(
                $this->subject,
                $body
            ),
            $template
        );

        return $template;
    }


    public static function markersDescriptions()
    {
        return array(
            '{{SUBJECT}}'               => 'Тема письма',
            '{{BODY}}'                  => 'Содержание письма',
            '{{ACTIVATE_ACCOUNT_HREF}}' => 'Адрес ссылки активации аккаунта'
        );
    }
}
