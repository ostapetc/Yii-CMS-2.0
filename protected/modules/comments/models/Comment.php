<?
/**
 * @property $id
 * @property $user_id
 * @property $root
 * @property $left
 * @property $right
 * @property $object_id
 * @property $model_id
 * @property $level
 * @property $text
 * @property $date_create
 */
class Comment extends ActiveRecord
{
    const PAGE_SIZE = 20;

    const COMMENTS_DENIED_ATTRIBUTE = 'comments_denied ';

    public $target_model;


    public function name()
    {
        return 'Комментарий';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'comments';
    }


    public function rules()
    {
        return array(
            array(
                'text',
                'required'
            ),
            array(
                'root',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'object_id',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'model_id',
                'length',
                'max' => 50
            ),
            array(
                'object_id',
                'ModelExistsValidator'
            ),
            array(
                'object_id',
                'deniedValidator'
            )
        );
    }


    public function deniedValidator()
    {
//        $attribute = self::COMMENTS_DENIED_ATTRIBUTE;
//        v(array_key_exists($attribute, $this->target_model->attributes)); die;
//        if (!$this->target_model || !array_key_exists($attribute, $this->target_model->attributes))
//        {
//            return;
//        }
//        die('da');
//        if ($this->target_model->$attribute)
//        {
//            $this->addError('object_id', t('comments denied'));
//            die('poppo');
//        }
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['nestedSetBehavior'] = array(
            'class'          => 'application.components.activeRecordBehaviors.NestedSetBehavior',
            'hasManyRoots'   => true,
            'leftAttribute'  => 'left',
            'rightAttribute' => 'right',
            'levelAttribute' => 'level',
        );
        return $behaviors;
    }


    public function relations()
    {
        return array(
            'user' => array(
                self::BELONGS_TO,
                'User',
                'user_id'
            )
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('root', $this->root, true);
        $criteria->compare('left', $this->left, true);
        $criteria->compare('right', $this->right, true);
        $criteria->compare('level', $this->level, true);
        $criteria->compare('text', $this->text, true);
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
        return Yii::app()->createUrl('/comments/comment/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }


    public function setModel(ActiveRecord $model)
    {
        $this->object_id = $model->primaryKey;
        $this->model_id  = get_class($model);
        return $this;
    }


    public function formatDateCreate()
    {
        return Yii::app()->dateFormatter->formatDateTime(strtotime($this->date_create), 'long', 'short');
    }
}
