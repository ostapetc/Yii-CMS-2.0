<?php

class News extends ActiveRecordModel
{
    const PAGE_SIZE = 15;

    const PHOTOS_DIR = 'upload/news';

    const STATE_ACTIVE = 'active';
    const STATE_HIDDEN = 'hidden';

    const PHOTO_SMALL_WIDTH  = "230";
    const PHOTO_SMALL_HEIGHT = "200";
    const PHOTO_BIG_WIDTH    = "580";

    public static $states = array(
        self::STATE_ACTIVE => 'Активна',
        self::STATE_HIDDEN => 'Скрыта'
    );


    public function name()
    {
        return 'Новости';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
            'FileManager'     => array(
                'class'          => 'application.components.activeRecordBehaviors.AttachmentBehavior',
                'attached_model' => 'FileManager'
            ),
            'MetaTagBehavior' => array(
                'class' => 'application.components.activeRecordBehaviors.MetaTagBehavior'
            )
        ));
    }


    public function tableName()
    {
        return 'news';
    }


    public function scopes()
    {
        return array(
            'last'   => array('order' => 'date DESC'),
            'active' => array('condition' => "state = '" . self::STATE_ACTIVE . "'")
        );
    }

public $roles;
    public function rules()
    {
        return array(
            array(
                'user_id, title, text, state, lang',
                'required'
            ),
            array(
                'photo',
                'file',
                'types'      => 'jpg, jpeg, gif, png, tif',
                'allowEmpty' => true,
                'maxSize'    => 1024 * 1024 * 2.5,
                'tooLarge'   => 'Максимальный размер файла 2.5 Мб'
            ),
            array(
                'meta_tags, roles',
                'safe',
                'on' => array(
                    self::SCENARIO_CREATE,
                    self::SCENARIO_UPDATE
                )
            ),
            array(
                'user_id',
                'length',
                'max' => 11
            ),
            array(
                'date',
                'type',
                'type'       => 'date',
                'dateFormat' => 'dd.mm.yyyy'
            ),
            array(
                'title',
                'length',
                'max' => 250
            ),
            array(
                'state',
                'length',
                'max' => 6
            ),
            array(
                'id, user_id, title, text, photo, state, date, date_create',
                'safe',
                'on' => 'search'
            ),
        );
    }


    public function relations()
    {
        return array(
            'user'     => array(
                self::BELONGS_TO,
                'User',
                'user_id'
            ),
            'language' => array(
                self::BELONGS_TO,
                'Language',
                'lang'
            ),
            'files'    => array(
                self::HAS_MANY,
                'FileManager',
                'object_id',
                'condition' => 'files.model_id = "' . get_class($this) . '" AND files.tag="images"',
                'order'     => 'files.order DESC'
            )
        );
    }


    public function search()
    {
        $alias = $this->getTableAlias();

        $criteria = new CDbCriteria;
        $criteria->compare($alias . '.id', $this->id, true);
        $criteria->compare($alias . '.user_id', $this->user_id, true);
        $criteria->compare($alias . '.title', $this->title, true);
        $criteria->compare($alias . '.text', $this->text, true);
        $criteria->compare($alias . '.photo', $this->photo);
        $criteria->compare($alias . '.state', $this->state, true);
        $criteria->compare($alias . '.date', $this->date, true);
        $criteria->compare($alias . '.date_create', $this->date_create, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria' => $criteria
        ));
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if (!$this->date)
            {
                $this->date = date("Y-m-d");
            }

            return true;
        }
    }


    public function uploadFiles()
    {
        return array(
            'photo' => array('dir' => self::PHOTOS_DIR)
        );
    }


    public function getContent()
    {
        if (RbacModule::isAllow('NewsAdmin_Update'))
        {
            $this->text .= "<br/> <a href='{$this->updateUrl}' class='admin_link'>Редактировать</a>";
        }

        return $this->text;
    }


    public function getLastNewsForMailer()
    {
        $length = 300;

        $news = $this->active()->last()->find();

        if (mb_strlen($news->text) > $length)
        {
            $pos = mb_strpos($news->text, '.', $length);

            $news->text = mb_substr($news->text, 0, $pos) . '...';
        }

        return $news->text;
    }


    public function getUrl()
    {
        return Yii::app()->controller->url("/news/{$this->id}");
    }


    public function getUpdateUrl()
    {
        return "/news/newsAdmin/update/id/{$this->id}";
    }
}
