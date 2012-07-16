<?
/**
 * @property $id
 * @property $result_id
 * @property $question_id
 * @property $inner_choice
 * @property $free_choice
 * @property $is_right
 */
class QuizChoice extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Ответ тестирования';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'quiz_choices';
    }


    public function rules()
    {
        return array(
            array(
                'result_id, question_id',
                'required'
            ),
            array(
                'inner_choice, free_choice',
                'length',
                'max' => 200
             ),

            array(
                'id, result_id, question_id, is_right',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'is_right',
                'in',
                'range' => array(0, 1)
            )
        );
    }


    public function relations()
    {
        return array(
            'question' => array(
                self::BELONGS_TO,
                'QuizQuestion',
                'question_id'
            ),
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('result_id', $this->result_id, true);
        $criteria->compare('question_id', $this->question_id, true);
        $criteria->compare('inner_choice', $this->inner_choice, true);
        $criteria->compare('free_choice', $this->free_choice, true);
        $criteria->compare('is_right', $this->is_right, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/quiz/quizchoice/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }
}
