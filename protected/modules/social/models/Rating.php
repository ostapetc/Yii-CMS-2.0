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


    public static function get(ActiveRecord $model)
    {
        $sql = "SELECT SUM(`value`)
                       FROM " . self::tableName() . "
                       WHERE object_id = '{$model->id}' AND
                             model_id  = '" .  get_class($model) . "'";

        return Yii::app()->db->createCommand($sql)->queryScalar();
    }


    public static function getHtml($model_or_rating)
    {
        if ($model_or_rating instanceof ActiveRecord)
        {
            $rating = self::get($model_or_rating);
        }
        else
        {
            $rating = $model_or_rating;
        }

        if ($rating == 0)
        {
            $class = 'grey';
        }
        else if ($rating > 0)
        {
            $class  = 'green';
            $rating = '+' . $rating;
        }
        else
        {
            $class = 'red';
        }

        return "<span class='rating-value {$class}'>{$rating}</span>";
    }
}
