<?
/**
 * @property $id
 * @property $name
 * @property $date_create
 */
class Quiz extends ActiveRecord
{
    const PAGE_SIZE = 20;

    public $topics_ids;


    public function name()
    {
        return 'Тест';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'quiz';
    }


    public function rules()
    {
        return array(
            array(
                '',
                'required'
            ),
            array(
                'name',
                'length',
                'max' => 200
             ),

            array(
                'name',
                'unique'
            ),
            array(
                'topics_ids',
                'safe',
                'on' => array(
                    self::SCENARIO_CREATE,
                    self::SCENARIO_UPDATE
                )
            )
        );
    }


    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            array(
                'topics_count' => 'Кол-во тематик',
                'topics_list'  => 'Список тематик'
            )
        );
    }


    public function relations()
    {
        return array(
            'topics_count' => array(
                self::STAT,
                'QuizTopicRel',
                'quiz_id'
            ),
            'topics_rels' => array(
                self::HAS_MANY,
                'QuizTopicRel',
                'quiz_id'
            ),
            'topics' => array(
                self::HAS_MANY,
                'QuizTopic',
                'topic_id',
                'through' => 'topics_rels'
            ),
            'questions' => array(
                self::HAS_MANY,
                'QuizQuestion',
                'topic_id',
                'through' => 'topics_rels'
            )
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
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
        return Yii::app()->createUrl('/quiz/quiz/view', array('id' => $this->id));
    }


    public function updateTopicsRels()
    {
        QuizTopicRel::model()->deleteAll("quiz_id = {$this->id}");

        if ($this->topics_ids)
        {
            foreach ($this->topics_ids as $topic_id)
            {
                $rel = new QuizTopicRel();
                $rel->quiz_id  = $this->id;
                $rel->topic_id = $topic_id;
                $rel->save();
            }
        }
    }


    public function getTopicsList()
    {
        $list = array();

        if (!$this->topics)
        {
            return;
        }

        foreach ($this->topics as $topic)
        {
            $list[] = CHtml::link(
                $topic->name,
                Yii::app()->createUrl('quiz/quizTopicAdmin/view', array('id' => $topic->id))
            );
        }

        return implode(', ', $list);
    }


    public function getTopicsCountValue()
    {
        if ($this->topics_count > 0)
        {
            return CHtml::link(
                $this->topics_count,
                Yii::app()->createUrl('quiz/quizTopicAdmin/manage', array('quiz_id' => $this->id))
            );
        }

        return 0;
    }
}
