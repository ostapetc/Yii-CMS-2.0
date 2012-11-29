<?
/** 
 * 
 * !Attributes - атрибуты БД
 * @property string  $id
 * @property string  $user_id
 * @property string  $object_id
 * @property string  $model_id
 * @property integer $value
 * @property string  $date_create
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property         $errorsFlatArray
 * @property         $url
 * @property         $updateUrl
 * @property         $createUrl
 * @property         $deleteUrl
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   Rating  ordered()
 * @method   Rating  last()
 * 
 */

class Rating extends ActiveRecord
{
    const PAGE_SIZE = 20;


    public $sum;

    public function name()
    {
        return 'Рейтинг';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'ratings';
    }


    public function rules()
    {
        return array(
            array(
                'object_id, model_id, value',
                'required'
            ),
            array(
                'model_id',
                'length',
                'max' => 50
            ),
            array(
                'object_id',
                'ObjectExistsValidator'
            ),
            array(
                'user_id',
                'NotObjectAuthorValidator'
            ),
            array(
                'user_id',
                'MultiUniqueValidator',
                'unique_attributes' => array(
                    'user_id', 'object_id', 'model_id'
                )
            ),
            array(
                'value', 'in', 'range' => array('1', '-1')
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('object_id', $this->object_id, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('date_create', $this->date_create, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public static function getValue($model, $object_id = null)
    {
        if ($model instanceof ActiveRecord)
        {
            $model_id  = get_class($model);
            $object_id = $model->id;
        }
        else
        {
            if (!is_numeric($object_id))
            {
                throw new CException(t('Неверные аргументы'));
            }

            $model_id = $model;
        }

        $rating = static::model()->findByAttributes([
            'object_id' => $object_id,
            'model_id' => $model_id
        ], [
            'select' => 'SUM(`value`) as sum'
        ])->sum;

        if (is_null($rating))
        {
            return 0;
        }
        else
        {
            return $rating;
        }
    }


    /**
     * @param $rating_value mixed (integer rating value or ActiveRecord model)
     * @return string
     */
    public static function getHtml($rating_value, array $html_options = array())
    {
        if ($rating_value instanceof ActiveRecord)
        {
            $rating_value = self::getValue($rating_value);
        }

        if ($rating_value == 0)
        {
            $rating_value = 0;
            $class        = 'grey';
        }
        else if ($rating_value > 0)
        {
            $rating_value = '+' . $rating_value;
            $class        = 'green';
        }
        else
        {
            $class = 'red';
        }

        if (isset($html_options['class']))
        {
            $html_options['class'].= " rating-value {$class}";
        }
        else
        {
            $html_options['class'] = "rating-value {$class}";
        }

        return CHtml::tag('span', $html_options, $rating_value);
    }
}
