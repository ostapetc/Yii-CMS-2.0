<?
/**
 * @property $id
 * @property $topic_id
 * @property $text
 * @property $date_create
 */
class QuizQuestion extends ActiveRecord
{
    const PAGE_SIZE = 20;


    public function name()
    {
        return 'Вопрос тестирования';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'quiz_questions';
    }


    public function rules()
    {
        return array(
            array(
                'topic_id, text',
                'required'
            ),
            array(
                'topic_id, text, date_create, answers_count',
                'safe',
                'on' => ActiveRecord::SCENARIO_SEARCH
            ),
            array(
                'text', 'filter', 'filter' => 'trim'
            )
        );
    }


    public function relations()
    {
        return array(
            'topic' => array(
                self::BELONGS_TO,
                'QuizTopic',
                'topic_id'
            ),
            'answers_count' => array(
                self::STAT,
                'QuizAnswer',
                'question_id'
            ),
            'answers' => array(
                self::HAS_MANY,
                'QuizAnswer',
                'question_id'
            )
        );
    }


    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            array(
                'answers_count' => 'Ответы',
                'short_text'    => 'Вопрос'
            )
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('topic_id', $this->topic_id, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('date_create', $this->date_create, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' => array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/quiz/quizquestion/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }


    public function getTopicIdValue()
    {
        return $this->topic ? $this->topic->name : null;
    }


    public function getTopicIdFilter()
    {
        return QuizTopic::model()->optionsTree();
    }


    public function getAnswersCountFilter()
    {
        return false;
    }


    public function getAnswersCountValue()
    {
        $value = $this->answers_count;
        if ($this->answers_count > 0)
        {
            $value = CHtml::link(
                $value, Yii::app()->createUrl('/quiz/quizAnswerAdmin/manage?QuizAnswer[question_id]=' . $this->id)
            );
        }

        $value.= str_repeat('&nbsp;', 4);
        $value.= CHtml::link(
            'добавить',
            Yii::app()->createUrl('/quiz/quizAnswerAdmin/create', array('question_id' => $this->id))
        );
        return $value;
    }


    public function getShortText()
    {
        $text = strip_tags($this->text);
        if ($text)
        {
            return CHtml::link(
                TextHelper::cut($text, 70, true),
                Yii::app()->createUrl('/quiz/quizQuestionAdmin/view/id/' . $this->id),
                array('title' => $text)
            );
        }
    }
}

