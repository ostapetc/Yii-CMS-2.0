<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property string  $model_id
 * @property string  $id
 * @property string  $user_id
 * @property string  $object_id
 * @property string  $root
 * @property string  $left
 * @property string  $right
 * @property integer $level
 * @property string  $text
 * @property string  $date_create
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property         $href
 * @property         $model
 * @property         $errorsFlatArray
 * @property         $url
 * @property         $updateUrl
 * @property         $createUrl
 * @property         $deleteUrl
 * 
 * !Relations - связи
 * @property User    $user
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   Comment published()
 * @method   Comment sitemap()
 * @method   Comment ordered()
 * @method   Comment last()
 * 
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
                'ObjectExistsValidator'
            )
        );
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
