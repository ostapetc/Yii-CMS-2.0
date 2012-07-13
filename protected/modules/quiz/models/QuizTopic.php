<?
/**
 * @property $id
 * @property $parent_id
 * @property $name
 * @property $date_create
 */
class QuizTopic extends ActiveRecord
{
    const PAGE_SIZE = 20;

    public $quiz_id;


    public function name()
    {
        return 'Тематики тестов';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'quiz_topics';
    }


    public function rules()
    {
        return array(
            array(
                'name',
                'required'
            ),
            array(
                'name',
                'length',
                'max' => 100
             ),

            array(
                'name',
                'unique'
            ),
            array(
                'parent_id',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'name, quiz_id',
                'safe',
                'on' => 'search'
            )
        );
    }


    public function relations()
    {
        return array(
            'childs' => array(
                self::HAS_MANY,
                'QuizTopic',
                'parent_id'
            ),
            'parent' => array(
                self::BELONGS_TO,
                'QuizTopic',
                'parent_id'
            ),
            'questions_count' => array(
                self::STAT,
                'QuizQuestion',
                'topic_id'
            )
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('parent_id', $this->parent_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('date_create', $this->date_create, true);

        if ($this->quiz_id)
        {
            $criteria->addCondition('
                id IN (
                    SELECT topic_id
                    FROM ' . QuizTopicRel::model()->tableName() . '
                    WHERE quiz_id = ' . $this->quiz_id . ')'
            );
        }

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/quiz/quiztopic/view', array('id' => $this->id));
    }


    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            array(
                'questions_count' => 'Кол-во вопросов'
            )
        );
    }


    public function getParentIdValue()
    {
        return $this->parent ? $this->parent->name : null;
    }


    public function getQuestionsCountValue()
    {
        if ($this->questions_count > 0)
        {
            return CHtml::link(
                $this->questions_count,
                Yii::app()->createUrl('quiz/quizQuestionAdmin/manage?QuizQuestion[topic_id]=' . $this->id)
            );
        }

        return $this->questions_count;
    }
}
