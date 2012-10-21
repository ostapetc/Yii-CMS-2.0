<?php
/**
 *
 * !Attributes - атрибуты БД
 *
 * @property integer    $id
 * @property string     $model_id
 * @property integer    $object_id
 * @property string     $title
 * @property string     $descr
 * @property string     $date_create
 * @property integer    $order
 *
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property            $href
 * @property CComponent $owner           the owner component that this behavior is attached to.
 * @property            $errorsFlatArray
 * @property            $url
 * @property            $updateUrl
 * @property            $createUrl
 * @property            $deleteUrl
 *
 * !Relations - связи
 * @property TagRel[]   $tags_rels
 * @property            $tags
 *
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   MediaAlbum ordered()
 * @method   MediaAlbum last()
 *
 */

class MediaAlbum extends ActiveRecord
{
    const SCENARIO_CREATE_USERS = 'create_users';
    const SCENARIO_UPDATE_USERS = 'update_users';

    const STATUS_ACTIVE  = 'active';
    const STATUS_DELETED = 'deleted';

    public static $status_options = [
        self::STATUS_ACTIVE  => 'активен',
        self::STATUS_DELETED => 'удален'
    ];

    public static $users_page_size = [
        'width'  => 260,
        'height' => 100
    ];

    public static $image_size = [
        'width'  => 160,
        'height' => 80
    ];


    public function name()
    {
        return 'Альбомы';
    }


    /**
     * @param string $className
     *
     * @return self
     */
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
        return CMap::mergeArray(parent::behaviors(), [
            'FileManager' => [
                'class' => 'application.components.activeRecordBehaviors.FileManagerBehavior',
                'tags'  => [
                    'files' => [
                        'title'     => 'Файлы',
                        'data_type' => 'image'
                    ]
                ]
            ],
        ]);
    }


    public function rules()
    {
        return [
            [
                'title, model_id, object_id',
                'required'
            ],
            [
                'title',
                'length',
                'max'=> 200
            ],
            [
                'title, descr',
                'filter',
                'filter' => 'strip_tags'
            ],
            [
                'id, title, descr, date_create',
                'safe',
                'on'=> 'search'
            ],
            [
                'files',
                'safe',
                'on' => [
                    self::SCENARIO_CREATE_USERS,
                    self::SCENARIO_UPDATE_USERS
                ]
            ],
            [
                'status',
                'in',
                'range' => array_keys(self::$status_options)
            ],
        ];
    }


    public function getParentModel()
    {
        return ActiveRecord::model($this->model_id)->findByPk($this->object_id);
    }


    public function relations()
    {
        return [
            'tags_rels'      => [
                self::HAS_MANY,
                'TagRel',
                'object_id',
                'condition' => "model_id = '" . get_class($this) . "'"
            ],
            'tags'           => [
                self::HAS_MANY,
                'Tag',
                'tag_id',
                'through' => 'tags_rels'
            ],
            'comments_count' => array(
                self::STAT,
                'Comment',
                'object_id',
                'condition' => 'model_id = "Page"'
            ),
        ];
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('descr', $this->descr, true);
        $criteria->compare('status', $this->status, true);

        return new ActiveDataProvider(get_class($this), [
            'criteria'   => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE
            ]
        ]);
    }


    public function getHref()
    {
        return Yii::app()->controller->createUrl('/media/mediaAlbum/view', [
            'id' => $this->id,
        ]);
    }


    public function parentModel($model, $positive = true)
    {
        if ($model)
        {
            $pk = $model->getIsNewRecord() ? null : $model->getPrimaryKey();
            return $this->parent(get_class($model), $pk, $positive);
        }
        return $this;
    }


    public function parent($model_id, $object_id, $positive = true)
    {
        $op        = $positive ? '=' : '<>';
        $alias     = $this->getTableAlias();
        $params    = [
            'model_id' => $model_id
        ];
        $condition = "$alias.model_id $op :model_id";
        if ($object_id)
        {
            $condition .= " AND $alias.object_id $op :object_id";
            $params['object_id'] = $object_id;
        }
        $this->getDbCriteria()->mergeWith([
            'condition' => $condition,
            'order'     => "$alias.order DESC",
            'params'    => $params
        ]);
        return $this;
    }


    public function notParent($model_id, $object_id)
    {
        return $this->parent($model_id, $object_id, false);
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
