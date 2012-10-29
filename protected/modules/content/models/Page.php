<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property string           $source
 * @property string           $source_url
 * @property string           $image
 * @property string           $language
 * @property string           $status
 * @property integer          $comments_denied
 * @property string           $id
 * @property string           $user_id
 * @property string           $title
 * @property string           $url
 * @property string           $text
 * @property string           $date_create
 * @property string           $date_update
 * @property integer          $order
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property                  $href
 * @property                  $content
 * @property                  $errorsFlatArray
 * @property                  $updateUrl
 * @property                  $createUrl
 * @property                  $deleteUrl
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
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   Page             published()
 * @method   Page             sitemap()
 * @method   Page             ordered()
 * @method   Page             last()
 * 
 */

class Page extends ActiveRecord
{
    const PAGE_SIZE = 20;

    const TAG_CUT = '{{cut}}';

    const TEXT_PREVIEW_LENGHT = 370;

    const IMAGES_DIR        = '/upload/pages/';
    const IMAGES_SIZE_SMALL = 200;

    const TYPE_POST  = 'post';
    const TYPE_FORUM = 'forum';

    const STATUS_UNPUBLISHED = 'unpublished';
    const STATUS_PUBLISHED   = 'published';
    const STATUS_DRAFT       = 'draft';

    public static $status_options = [
        self::STATUS_UNPUBLISHED => 'неопубликовано',
        self::STATUS_PUBLISHED   => 'опубликовано',
        self::STATUS_DRAFT       => 'черновик'
    ];

    public $sections_ids;

    public $sports_ids;


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
            [
                 'Tag' => ['class' => 'application.components.activeRecordBehaviors.TagBehavior'],
                 'FileManager' => [
                     'class' => 'application.components.activeRecordBehaviors.FileManagerBehavior',
                     'tags' => [
                         'gallery' => [
                             'title' => 'Галерея',
                             'data_type' => 'image'
                         ]
                     ]
                 ],
                'SportRel' => [
                    'class' => 'application.modules.content.components.activeRecordBehaviors.SportRelBehavior'
                ]
            ]
        );
    }


    public function rules()
    {
        return [
            ['title, language', 'required'],
            ['language', 'safe'],
            [
                'title', 'length',
                'max'=> 200
            ],
            ['text, short_text', 'safe'],
            ['meta_tags, god', 'safe'],
            [
                'title', 'filter',
                'filter' => 'strip_tags'
            ],
            [
                'gallery', 'safe',
            ],
            [
                'id, title, text, status, date_create, date_publish', 'safe',
                'on'=> 'search'
            ],
            [
                'status',
                'in',
                'range' => array_keys(self::$status_options)
            ],
            [
                'user_id',
                'numerical',
                'integerOnly' => true
            ],
            [
                'sections_ids, tags, sports_ids',
                'safe',
                'on' => [
                    self::SCENARIO_CREATE,
                    self::SCENARIO_UPDATE
                ]
            ],
            [
                'comments_denied',
                'in',
                'range' => [0, 1]
            ],
            [
                'image',
                'file',
                'types' => 'jpg, png, jpeg, gif',
                'allowEmpty' => true
            ],
            [
                'source',
                'length',
                'max' => 50
            ],
            [
                'source_url',
                'length',
                'max' => 250
            ]
        ];
    }


    public function relations()
    {
        return [
            'language_model' => [
                self::BELONGS_TO,
                'Language',
                'language'
            ],
            'tags_rels' => [
                self::HAS_MANY ,
                'TagRel',
                'object_id',
                'condition' => "model_id = 'Page'"
            ],
            'tags' => [
                self::HAS_MANY,
                'Tag',
                'tag_id',
                'through' => 'tags_rels'
            ],
            'comments_count' => [
                self::STAT,
                'Comment',
                'object_id',
                'condition' => 'model_id = "Page"'
            ],
            'user' => [
                self::BELONGS_TO,
                'User',
                'user_id'
            ],
            'sections_rels' => [
                self::HAS_MANY,
                'PageSectionRel',
                'page_id'
            ],
            'sections' => [
                self::HAS_MANY,
                'PageSection',
                'section_id',
                'through' => 'sections_rels'
            ]
        ];
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('date_create', $this->date_create, true);
        $criteria->compare('language', $this->language, true);

        return new ActiveDataProvider(get_class($this), [
             'criteria'   => $criteria,
             'pagination' => [
                 'pageSize' => self::PAGE_SIZE
             ]
        ]);
    }

    public function attributeLabels()
    {
        return CMap::mergeArray(
            parent::attributeLabels(),
            [
                'sections_ids' => t('Разделы'),
                'tags'         => t('Теги'),
                'sports_ids'   => t('Вид спорта')
            ]
        );
    }


    public function getContent()
    {
        $content = $this->text;

        if (Yii::app()->user->checkAccess('PageAdmin_Update'))
        {
            $content .= "<br/>" . CHtml::link(t('Редактировать'), ['/content/pageAdmin/update/','id'=> $this->id], ['class'=> 'btn btn-danger']);
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


    public function uploadFiles()
    {
        return [
            'image' => [
                'dir' => self::IMAGES_DIR
            ]
        ];
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


    public function getForumUrl()
    {
        return Yii::app()->createUrl('/content/forum/viewTopic', ['topic_id' => $this->id]);
    }


    public function getLastComment()
    {
        $sql = "SELECT *
                       FROM comments
                       WHERE object_id = {$this->id} AND
                             model_id  = 'Page'
                       ORDER BY date_create DESC
                       LIMIT 1";

        return Comment::model()->findBySql($sql);
    }


    public function getImageSrc($size = self::IMAGES_SIZE_SMALL)
    {
        if (!$this->image) return;

        $thumb = ImageHelper::thumb(
            self::IMAGES_DIR,
            $this->image,
            ['width' => $size, 'height' => $size]
        );

        if ($thumb)
        {
            return $thumb->getSrc();
        }
    }


    public function getTextPreview()
    {
        if (mb_strpos($this->text, self::TAG_CUT) !== false)
        {
            $parts = explode(self::TAG_CUT, $this->text);
            return array_shift($parts);
        }
        else
        {
            return Yii::app()->text->cut($this->text, self::TEXT_PREVIEW_LENGHT, '...');
        }
    }


    public function getUserId()
    {
        return $this->user_id;
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->status == self::STATUS_PUBLISHED)
            {
                if ($this->isNewRecord)
                {
                    $this->date_publish = new CDbExpression('NOW()');
                }
                else
                {
                    $self = $this->findByPk($this->id);
                    if ($self->status != self::STATUS_PUBLISHED)
                    {
                        $this->date_publish = new CDbExpression('NOW()');
                    }
                }
            }

            return true;
        }
    }


    public function getTextImageDir()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . self::IMAGES_DIR . $this->id . DS;
        if (!is_dir($dir))
        {
            mkdir($dir, 0777);
            chmod($dir, 0777);
        }

        return $dir;
    }


    public function grabImages()
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($this->text);

        $xpath  = new DOMXPath($doc);
        $images = $xpath->query('//img');

        foreach ($images as $image)
        {
            $src = trim($image->getAttribute('src'));
            if (mb_substr($src, 0, 4, 'utf-8') == 'http')
            {
                $img  = file_get_contents($src);
                $path = $this->getTextImageDir() . md5($src) . '.' . pathinfo($src, PATHINFO_EXTENSION);

                file_put_contents($path, $img);
                chmod($path, 0777);

                $path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);
                $this->text = str_replace($src, $path, $this->text);
            }
            else
            {
                die('howto grab ' . $src);
            }
        }
    }


    public function grabTagsFromText()
    {
        /**
         * @var $tag DOMElement
         */

        $doc = new DOMDocument();
        @$doc->loadHTML($this->text);

        $xpath = new DOMXPath($doc);
        $tags  = $xpath->query('//strong');

        foreach ($tags as $tag_name)
        {
            $tag_name = utf8_decode($tag_name->textContent);

            $tag = Tag::model()->findByAttributes(['name' => $tag_name]);
            if (!$tag)
            {
                $tag = new Tag();
                $tag->name = $tag_name;
                $tag->throwIfErrors()->save();
            }

            $tag_rel = TagRel::createIfNotExists($tag->id, $this);
        }
    }
}
