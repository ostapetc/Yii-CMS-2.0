<?
/**
 * @property $id
 * @property $user_id
 * @property $object_id
 * @property $model_id
 * @property $value
 * @property $date_create
 */
class Rating extends ActiveRecord
{
    const PAGE_SIZE = 20;



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


    public function getHref()
    {
        return Yii::app()->createUrl('/rating/rating/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
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

        $sql = "SELECT SUM(`value`)
                       FROM " . self::tableName() . "
                       WHERE object_id = '{$object_id}' AND
                             model_id  = '" . $model_id . "'";

        $rating = Yii::app()->db->createCommand($sql)->queryScalar();
        if (is_null($rating))
        {
            return 0;
        }
        else
        {
            return $rating;
        }
    }


    public static function getHtml($rating_value)
    {
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

        return "<div class='rating-value {$class}'>{$rating_value}</div>";
    }
}
