<?
/**
 * @property $id
 * @property $user_id
 * @property $root
 * @property $left
 * @property $right
* @property  $object
 * @property $level
 * @property $text
 * @property $date_create
 */
class Comment extends ActiveRecord
{
    const PAGE_SIZE = 20;



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
                'object',
                'objectExists'
            )
        );
    }


    public function objectExists()
    {
        $object = explode('_', $this->object);
        if (count($object) == 2)
        {
            list($class, $pk) = $object;
            $model = ActiveRecord::model($class)->findByPk($pk);
            if ($model)
            {
                return true;
            }
        }

        $this->addError('object', 'невалидный');
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


    public static function defineObject(ActiveRecord $model)
    {
        return get_class($model) . '_' . $model->primaryKey;
    }
}
