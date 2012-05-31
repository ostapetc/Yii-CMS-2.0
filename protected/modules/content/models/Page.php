<?

class Page extends ActiveRecord
{
    const PAGE_SIZE = 20;

    const STATUS_UNPUBLISHED = 'unpublished';
    const STATUS_PUBLISHED   = 'published';
    const STATUS_DRAFT       = 'draft';

    public static $status_options = array(
        self::STATUS_UNPUBLISHED => 'неопубликовано',
        self::STATUS_PUBLISHED   => 'опубликовано',
        self::STATUS_DRAFT       => 'черновик'
    );


    public function name()
    {
        return 'Страницы';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'pages';
    }


    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            array(
                 'Tag' => array('class' => 'application.components.activeRecordBehaviors.TagBehavior'),
                 'FileManager' => array('class' => 'application.components.activeRecordBehaviors.FileManagerBehavior'),
            )
        );
    }


    public function rules()
    {
        return array(
            array('title, language', 'required'),
            array('language', 'safe'),
            array(
                'url', 'length',
                'max' => 250
            ),
            array(
                'title', 'length',
                'max'=> 200
            ),
            array('text, short_text', 'safe'),
            array('meta_tags, god', 'safe'),
            array(
                'title, url', 'filter',
                'filter' => 'strip_tags'
            ),
            array(
                'id, title, url, text, date_create', 'safe',
                'on'=> 'search'
            ),
            array(
                'status',
                'in',
                'range' => array_keys(self::$status_options)
            ),
            array(
                'user_id',
                'numerical',
                'integerOnly' => true
            )
        );
    }


    public function relations()
    {
        return array(
            'language_model' => array(
                self::BELONGS_TO,
                'Language',
                'language'
            ),
            'tags_rels' => array(
                self::HAS_MANY ,
                'TagRel',
                'object_id',
                'condition' => "model_id = 'Page'"
            ),
            'tags' => array(
                self::HAS_MANY,
                'Tag',
                'tag_id',
                'through' => 'tags_rels'
            ),
            'gallery' => Yii::app()->getModule('fileManager')->getRelation($this, 'gallery'),
            'comments_count' => array(
                self::STAT,
                'Comment',
                'object_id',
                'condition' => "model_id = 'Page'"
            )
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('date_create', $this->date_create, true);
        $criteria->compare('language', $this->language, true);

        return new ActiveDataProvider(get_class($this), array(
             'criteria'   => $criteria,
             'pagination' => array(
                 'pageSize' => self::PAGE_SIZE
             )
        ));
    }


    public function getHref()
    {
        $url = trim($this->url);
        if ($url)
        {
            if ($url[0] != "/")
            {
                $url = "/page/{$url}";
            }

            return $url;
        }
        else
        {
            return "/page/" . $this->id;
        }
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->url != '/')
            {
                $this->url = trim($this->url, "/");
            }

            return true;
        }
    }


    public function getContent()
    {
        $content = $this->text;

        if (RbacModule::isAllow('PageAdmin_Update'))
        {
            $content .= "<br/>" . CHtml::link(t('Редактировать'), array('/content/pageAdmin/update/','id'=> $this->id), array('class'=> 'btn btn-danger'));
        }

        return $content;
    }
}
