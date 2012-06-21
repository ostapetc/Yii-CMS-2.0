<?

class FileAlbum extends ActiveRecord
{
    const PAGE_SIZE = 20;

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
        return 'file_albums';
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            array(
                 'FileManager' => array(
                     'class' => 'application.components.activeRecordBehaviors.FileManagerBehavior',
                     'tags' => array(
                         'files' => array(
                             'title' => 'Файлы',
                             'data_type' => 'image'
                         )
                     )
                 ),
            )
        );
    }


    public function rules()
    {
        return array(
            array('title, model_id, object_id', 'required'),
            array(
                'title', 'length',
                'max'=> 200
            ),
            array(
                'title, descr', 'filter',
                'filter' => 'strip_tags'
            ),
            array(
                'id, title, descr, date_create', 'safe',
                'on'=> 'search'
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
                self::HAS_MANY ,
                'TagRel',
                'object_id',
                'condition' => "model_id = '".get_class($this)."'"
            ),
            'tags' => array(
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
        return Yii::app()->controller->createUrl('/fileManager/fileAlbum/view', array('id' => $this->id));
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
}
