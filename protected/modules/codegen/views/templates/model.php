<? echo "<?\n"; ?>

class <?= $class ?> extends ActiveRecord
{
    const PAGE_SIZE = 20;

<? foreach ($constants as $constants_part): ?>
<? foreach ($constants_part as $constant): ?>
    const <?= $constant ?>;
<? endforeach ?>

<? endforeach ?>
<? foreach ($constants as $field => $constants_part): ?>
    public static $<?= $field ?>_options = array();
<? endforeach ?>


    public function name()
    {
        return '<?= $name ?>';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return '<?= $table ?>';
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return $behaviors;
    }


    public function rules()
    {
        return array(
            <?= $rules ?>
        );
    }


    public function relations()
    {
        return array(
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('view', array('id' => $this->id));
    }
}
