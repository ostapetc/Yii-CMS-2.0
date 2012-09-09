<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property string           $language
 * @property string           $status
 * @property string           $id
 * @property string           $user_id
 * @property string           $title
 * @property string           $url
 * @property string           $text
 * @property string           $date_create
 * @property integer          $order
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property                  $href
 * @property                  $content
 * @property                  $errorsFlatArray
 * 
 * !Relations - связи
 * @property Language         $language_model
 * @property TagRel[]         $tags_rels
 * @property Tag[]            $tags
 * @property int|null         $comments_count
 * @property User             $user
 * @property PageSectionRel[] $sections_rels
 * @property PageSection[]    $sections
 * 
 */

class Page extends ActiveRecord
{
    //public $tags_names;

    const PAGE_SIZE = 20;

    const STATUS_UNPUBLISHED = 'unpublished';
    const STATUS_PUBLISHED   = 'published';
    const STATUS_DRAFT       = 'draft';

    public $sections_ids;

    public $sports_ids;

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
        return CMap::mergeArray(
            parent::behaviors(),
            array(
                 'Tag' => array('class' => 'application.components.activeRecordBehaviors.TagBehavior'),
//                 'FileManager' => array(
//                     'class' => 'application.components.activeRecordBehaviors.FileManagerBehavior',
//                     'tags' => array(
//                         'gallery' => array(
//                             'title' => 'Галерея',
//                             'data_type' => 'image'
//                         )
//                     )
//                 ),
                'SportRel' => array(
                    'class' => 'application.modules.content.components.activeRecordBehaviors.SportRelBehavior'
                )
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
                'id, title, url, text, status, date_create', 'safe',
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
            ),
            array(
                'sections_ids, tags, sports_ids',
                'safe',
                'on' => array(
                    self::SCENARIO_CREATE,
                    self::SCENARIO_UPDATE
                )
            ),
            array(
                'comments_denied',
                'in',
                'range' => array(0, 1)
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
            'comments_count' => array(
                self::STAT,
                'Comment',
                'object_id',
                'condition' => 'model_id = "Page"'
            ),
            'user' => array(
                self::BELONGS_TO,
                'User',
                'user_id'
            ),
            'sections_rels' => array(
                self::HAS_MANY,
                'PageSectionRel',
                'page_id'
            ),
            'sections' => array(
                self::HAS_MANY,
                'PageSection',
                'section_id',
                'through' => 'sections_rels'
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


    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            array(
                'sections_ids' => t('Разделы'),
                'tags'         => t('Теги'),
                'sports_ids'   => t('Вид спорта')
            )
        );
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


    public function statusValue()
    {
        if (isset(self::$status_options[$this->status]))
        {
            return self::$status_options[$this->status];
        }
    }


    public function afterSave()
    {
        $this->updateSectionsRels();
        return parent::afterSave();
    }


    public function updateSectionsRels()
    {
        if (!is_array($this->sections_ids)) return;

        PageSectionRel::model()->deleteAll('page_id = ' . $this->id);

        foreach ($this->sections_ids as $section_id)
        {
            $rel = new PageSectionRel();
            $rel->section_id = $section_id;
            $rel->page_id    = $this->id;
            $rel->save();
        }
    }
}
