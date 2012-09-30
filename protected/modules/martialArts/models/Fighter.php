<?
/**
 * @property $id
 * @property $source_url
 * @property $source_name
 * @property $name
 * @property $nickname
 * @property $birthday
 * @property $association
 * @property $height
 * @property $weight
 */
class Fighter extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Боец';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'fighters';
    }


    public function rules()
    {
        return array(
            array(
                'source_url, source_name, source_path, name',
                'required'
            ),
            array(
                'source_url, name, nickname, association, country',
                'length',
                'max' => 100
            ),
            array(
                'source_name, source_path',
                'length',
                'max' => 20
            ),
            array(
                'image',
                'length',
                'max' => 150
            ),
            array(
                'source_url',
                'unique'
            ),
            array(
                'id',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'date_create, date_update',
                'safe'
            )
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
        $criteria->compare('source_url', $this->source_url, true);
        $criteria->compare('source_name', $this->source_name, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('nickname', $this->nickname, true);
        $criteria->compare('birthday', $this->birthday, true);
        $criteria->compare('association', $this->association, true);
        $criteria->compare('height', $this->height, true);
        $criteria->compare('weight', $this->weight, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if (!$this->isNewRecord)
            {
                $this->date_update = new CDbExpression('NOW()');
            }

            return true;
        }
    }


    public static function getPhotosDir()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . 'upload' . DS . 'fighters' . DS;
        if (!is_dir($dir))
        {
            mkdir($dir, 0777);
            chmod($dir, 0777);
        }

        return $dir;
    }
}
