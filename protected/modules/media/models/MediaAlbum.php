<?php
/**
 *
 * !Attributes - атрибуты БД
 *
 * @property                 $id
 * @property                 $title
 * @property                 $descr
 * @property                 $status
 * @property                 $model_id
 * @property                 $object_id
 * @property                 $order
 * @property                 $date_create
 *
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property                 $href
 * @property CComponent      $owner            the owner component that this behavior is attached to.
 * @property                 $errorsFlatArray
 *
 * !Relations - связи
 * @property TagRel[]        $tags_rels
 * @property                 $tags
 *
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   FileAlbum       published()
 * @method   FileAlbum       sitemap()
 * @method   FileAlbum       ordered()
 * @method   FileAlbum       last()
 *
 */

class MediaAlbum extends ActiveRecord
{
    const SCENARIO_CREATE_USERS = 'create_users';
    const SCENARIO_UPDATE_USERS = 'update_users';

    const STATUS_ACTIVE  = 'active';
    const STATUS_DELETED = 'deleted';

    public static $status_options = array(
        self::STATUS_ACTIVE  => 'активен',
        self::STATUS_DELETED => 'удален'
    );


    public function name()
    {
        return 'Альбомы';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'media_albums';
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
            'FileManager' => array(
                'class' => 'application.components.activeRecordBehaviors.FileManagerBehavior',
                'tags'  => array(
                    'files' => array(
                        'title'     => 'Файлы',
                        'data_type' => 'image'
                    )
                )
            ),
        ));
    }


    public function rules()
    {
        return array(
            array(
                'title, model_id, object_id',
                'required'
            ),
            array(
                'title',
                'length',
                'max'=> 200
            ),
            array(
                'title, descr',
                'filter',
                'filter' => 'strip_tags'
            ),
            array(
                'id, title, descr, date_create',
                'safe',
                'on'=> 'search'
            ),
            array(
                'files',
                'safe',
                'on' => array(
                    self::SCENARIO_CREATE_USERS,
                    self::SCENARIO_UPDATE_USERS
                )
            ),
            array(
                'status',
                'in',
                'range' => array_keys(self::$status_options)
            ),
        );
    }


    public function relations()
    {
        return array(
            'tags_rels' => array(
                self::HAS_MANY,
                'TagRel',
                'object_id',
                'condition' => "model_id = '" . get_class($this) . "'"
            ),
            'tags'      => array(
                self::HAS_MANY,
                'Tag',
                'tag_id',
                'through' => 'tags_rels'
            ),
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('descr', $this->descr, true);
        $criteria->compare('status', $this->status, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' => array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->controller->createUrl('/media/mediaAlbum/view', array('id' => $this->id));
    }


    public function parent($model_id, $id)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => "$alias.model_id='$model_id' AND $alias.object_id='$id'",
            'order'     => "$alias.order DESC"
        ));
        return $this;
    }


    public function getOwner()
    {
        return ActiveRecord::model($this->model_id)->findByPk($this->object_id);
    }


    public function isAttachedTo($model, $strict = false)
    {
        if ($model instanceof CActiveRecord)
        {
            if ($this->model_id == get_class($model) && $this->object_id == $model->getPrimaryKey())
            {
                return true;
            }
            elseif (!$strict)
            {
                $owner = $this->getOwner();
                if (is_object($owner) && method_exists($owner, 'isAttachedTo'))
                {
                    return $owner->isAttachedTo($model);
                }
                else
                {
                    return false;
                }
            }
        }
        return false;
    }


    public function userCanEdit($user = null)
    {
        $this->isAttachedTo($user ? $user : Yii::app()->user->model);
    }
}
