<?
/**
 * @property $id
 * @property $quiz_id
 * @property $topic_id
 */
class QuizTopicRel extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Связь с тематикой';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'quiz_topics_rels';
    }


    public function rules()
    {
        return array(
            array(
                'quiz_id, topic_id',
                'required'
            ),

            array(
                'id, quiz_id, topic_id',
                'numerical',
                'integerOnly' => true
            ),
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
        $criteria->compare('quiz_id', $this->quiz_id, true);
        $criteria->compare('topic_id', $this->topic_id, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/quiz/quiztopicrel/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }
}
