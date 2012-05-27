<? echo "<?\n"; ?>
/**
<? foreach ($meta as $data): ?>
 * @property $<?= $data['Field']."\n" ?>
<? endforeach ?>
 */
class <?= $class ?> extends ActiveRecord
{
    const PAGE_SIZE = 20;

<? foreach ($meta as $data): ?>
<? if (in_array($data['Field'], Model::$file_attributes)): ?>
    const <?= strtoupper($data['Field']) . '_DIR' ?> = '/upload/<?= $data['Field'] ?>/';
<? endif ?>
<? endforeach ?>

<? foreach ($constants as $constants_part): ?>
<? foreach ($constants_part as $constant): ?>
    const <?= $constant ?>;
<? endforeach ?>

<? endforeach ?>
<? foreach ($constants as $field => $constants_part): ?>
    public static $<?= $field ?>_options = array(
    <? foreach ($constants_part as $constant): ?>
    self::<?= str_replace('=', '=>', $constant) ?>,
    <? endforeach ?>
);

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

<? if (isset($behaviors) && $behaviors): ?>

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            array(
<? foreach ($behaviors as $behavior): ?>
                '<?= array_pop(explode('.', $behavior)) ?>' => '<?= $behavior ?>',
<? endforeach ?>
            )
        );
    }

<? endif  ?>

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
<? foreach ($meta as $data): ?>
        $criteria->compare('<?= $data['Field'] ?>', $this-><?= $data['Field'] ?>, true);
<? endforeach ?>

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/<?= $module ?>/<?= strtolower($class) ?>/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
<? foreach ($meta as $data): ?>
<? if (in_array($data['Field'], Model::$file_attributes)): ?>
            '<?= $data['Field'] ?>' => array(
                'dir' => self::<?= strtoupper($data['Field']) . '_DIR' ?>

            ),
<? endif ?>
<? endforeach ?>
        );
    }
}
