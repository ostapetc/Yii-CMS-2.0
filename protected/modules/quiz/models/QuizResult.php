<?
/**
 * @property $id
 * @property $user_id
 * @property $quiz_id
 * @property $date_start
 * @property $date_finish
 */
class QuizResult extends ActiveRecord
{
    const STATUS_PROCESS  = 'process';
    const STATUS_FINISHED = 'finished';

    const PAGE_SIZE = 20;

    public static $status_options = array(
        self::STATUS_PROCESS  => 'в процессе',
        self::STATUS_FINISHED => 'завершено'
    );


    public function name()
    {
        return 'Результат тестирования';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'quiz_results';
    }


    public function rules()
    {
        return array(
            array(
                'quiz_id, user_id',
                'required'
            ),
            array(
                'status',
                'in',
                'range' => array_keys(self::$status_options)
            ),
            array(
                'status',
                'default',
                'value' => self::STATUS_PROCESS
            ),
            array(
                'id, user_id, quiz_id',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'date_start',
                'default',
                'value' => new CDbExpression('NOW()')
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
        $criteria->compare('quiz_id', $this->quiz_id, true);
        $criteria->compare('date_start', $this->date_start, true);
        $criteria->compare('date_finish', $this->date_finish, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/quiz/quizresult/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }
}
