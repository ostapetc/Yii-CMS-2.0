<?
/**
 * @property $id
 * @property $question_id
 * @property $text
 * @property $is_right
 * @property $points
 */
class QuizAnswer extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Ответ на вопрос тестирования';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'quiz_answers';
    }


    public function rules()
    {
        return array(
            array(
                'question_id, text, is_right, points',
                'required'
            ),

            array(
                'id, question_id, is_right, points, is_free',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'text', 'filter', 'filter' => 'trim'
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
            )
        );
    }


    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            array(
                'question_link' => 'Вопрос'
            )
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('question_id', $this->question_id, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('is_right', $this->is_right, true);
        $criteria->compare('points', $this->points, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/quiz/quizanswer/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }


    public function getQuestionIdValue()
    {
        return $this->question->text;
    }


    public function getIsRightValue()
    {
        return $this->is_right ? t('да') : t('нет');
    }


    public function getQuestionLink()
    {
        if ($this->question)
        {
            return CHtml::link(
                TextHelper::cut($this->question->text, 50),
                Yii::app()->createUrl('/quiz/quizQuestionAdmin/view/id/' . $this->question_id)
            );
        }
    }
}
