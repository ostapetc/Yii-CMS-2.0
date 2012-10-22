<?
/** 
 * 
 * !Attributes - атрибуты БД
 * @property string             $id
 * @property string             $object_id
 * @property string             $model_id
 * @property string             $remote_id
 * @property string             $tag
 * @property string             $title
 * @property string             $descr
 * @property string             $order
 * @property string             $type
 * @property string             $api_name
 * @property string             $target_api
 * @property string             $status
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property                    $deleteUrl
 * @property                    $apiName
 * @property ApiAbstract        $api
 * @property                    $configuration
 * @property                    $nameWithoutExt
 * @property                    $downloadUrl
 * @property                    $hash
 * @property ActiveDataProvider $dataProvider
 * @property                    $errorsFlatArray
 * @property                    $url
 * @property                    $updateUrl
 * @property                    $createUrl
 * @property string             $error           the error message. Null is returned if no error.
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   MediaFile          ordered()
 * @method   MediaFile          last()
 * 
 */

class MediaFile extends ActiveRecord
{
    const STATUS_ON_MODERATE = 'on_moderate';
    const STATUS_ACTIVE      = 'active';
    const STATUS_DELETED     = 'deleted';

    const TYPE_IMG   = 'img';
    const TYPE_VIDEO = 'video';
    const TYPE_AUDIO = 'audio';
    const TYPE_DOC   = 'doc';

    public $types = [
        self::TYPE_IMG   => self::TYPE_IMG,
        self::TYPE_VIDEO => self::TYPE_VIDEO,
        self::TYPE_AUDIO => self::TYPE_AUDIO,
        self::TYPE_DOC   => self::TYPE_DOC,
    ];

    public static $configuration;

    public $error;

    private $_api_name;


    public function __construct($scenario = 'insert', $api_name = null)
    {
        $this->_api_name = $api_name;
        parent::__construct($scenario);
    }


    public function init()
    {
        if ($this->_api_name)
        {
            $this->setApi($this->_api_name);
        }
    }


    public function name()
    {
        return 'Файловый менеджер';
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
        return 'media_files';
    }

    public function getParentModel()
    {
        return ActiveRecord::model($this->model_id)->findByPk($this->object_id);
    }

    public function rules()
    {
        return [ /*            [
                'nameWithoutExt',
                'length',
                'min'      => 1,
                'max'      => 900,
                'tooShort' => 'Название файла должно быть меньше 1 сим.',
                'tooLong'  => 'Пожалуйста, сократите наименование файла до 900 сим.'
            ) */
        ];
    }


    public function toJson()
    {
        return [
            'title'      => $this->title ? $this->title : 'Кликните для редактирования',
            'descr'      => $this->descr ? $this->descr : 'Кликните для редактирования',
            'url'        => $this->getHref(),
            'preview'    => $this->getPreview(),
            'delete_url' => $this->deleteUrl,
            'api'        => $this->api_name,
        ];
    }


    public function parent($model_id, $object_id = null)
    {
        $alias     = $this->getTableAlias();
        $condition = "$alias.model_id=:model_id";
        $params    = [
            'model_id' => $model_id
        ];
        if ($object_id !== null)
        {
            $condition .= " AND $alias.object_id=:object_id";
            $params['object_id'] = $object_id;
        }
        $this->getDbCriteria()->mergeWith([
            'condition' => $condition,
            'params'    => $params
        ]);
        return $this;
    }


    public function tag($tag)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith([
            'condition' => "$alias.tag=:tag",
            'params'    => [
                'tag' => $tag
            ]
        ]);
        return $this;
    }


    public function type($type)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith([
            'condition' => "$alias.type=:type",
            'params'    => [
                'type' => $type
            ]
        ]);
        return $this;
    }


    public function getDeleteUrl()
    {
        return Yii::app()->createUrl('/media/mediaFileAdmin/delete', ['id' => $this->id]);
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


    public function getApiName()
    {
        return $this->_api_name;
    }


    /**
     * @return ApiAbstract
     */
    public function getApi()
    {
        return $this->asa('api')->getApiModel();
    }


    public static function getConfiguration($api_name = null)
    {
        if (!self::$configuration)
        {
            self::$configuration = new Configuration('media.midiaFile');
        }

        if ($api_name)
        {
            return self::$configuration[$api_name];
        }
        else
        {
            return self::$configuration;
        }
    }


    public function setApi($api_name)
    {
        if (!$api_name)
        {
            $api_name = 'local';
        }
        $this->detachBehavior('api');

        if ($api_name instanceof ApiAbstract)
        {
            $this->attachBehavior('api', $api_name);
        }
        else
        {
            $this->attachBehavior('api', $this->getConfiguration($api_name));
        }

        $this->api_name = $api_name;

        $aliace = $this->getTableAlias();
        $this->dbCriteria->mergeWith([
            'condition' => "$aliace.api_name=:api_name",
            'params'    => [
                'api_name' => $api_name
            ]
        ]);
        return $this;
    }


    public static function parse($source)
    {
        foreach (self::getConfiguration() as $api => $conf)
        {
            $model = new MediaFile('create', $api);
            if ($id = $model->getApi()->parse($source))
            {
                $model->remote_id = $id;
                $model->api_name  = $api;
                $model->getApi()->findByPk($id);
                break;
            }
        }

        return $model;
    }


    public function getNameWithoutExt()
    {
        $name   = pathinfo($this->remote_id, PATHINFO_FILENAME);
        $params = [' ' => ''];
        if (self::FILE_POSTFIX)
        {
            $params[self::FILE_POSTFIX] = '';
        }
        return strtr($name, $params);
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                $model       = MediaFile::model()->parent($this->model_id, $this->object_id)->tag($this->tag)
                    ->find();
                $this->order = $model ? $model->order + 1 : 1;
            }

            return true;
        }
        return false;
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


    public function search($crit = null)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('object_id', $this->object_id, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('tag', $this->tag, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('descr', $this->descr, true);
        $criteria->compare('order', $this->order);

        if ($crit)
        {
            $criteria->mergeWith($crit);
        }

        return new ActiveDataProvider(get_class($this), [
            'criteria' => $criteria
        ]);
    }


    public function afterFind()
    {
        $this->setApi($this->api_name);
        parent::afterFind();
    }


    public function getDownloadUrl()
    {
        $hash = $this->getHash();
        return Yii::app()->getController()->createUrl('/media/mediaFile/downloadFile', [
            'hash' => "{$hash}x{$this->id}",
        ]);
    }


    public function getHash()
    {
        return md5($this->object_id . $this->model_id . $this->name . $this->tag);
    }


    /**
     * @param null $model
     * @param null $tag
     *
     * @return ActiveDataProvider
     */
    public function getDataProvider($model = null, $tag = null)
    {
        $file = clone $this;
        if ($model instanceof CActiveRecord)
        {
            $pk = $model->getIsNewRecord() ? null : $model->getPrimaryKey();
            $file->parent(get_class($model), $pk);
        }
        if ($tag !== null)
        {
            $file->tag($tag);
        }

        return new ActiveDataProvider(get_called_class(), [
            'criteria' => $file->ordered()->getDbCriteria(),
        ]);
    }
}
