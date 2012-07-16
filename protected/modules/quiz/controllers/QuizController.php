<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 26.06.12
 * Time: 17:19
 * To change this template use File | Settings | File Templates.
 */
class QuizController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'quiz' => 'Тестирование'
        );
    }


    public function actionQuiz($id)
    {
        $quiz = Quiz::model()->findByPk($id);
        if (!$quiz)
        {
            $this->pageNotFound();
        }

        $quiz_result = QuizResult::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'quiz_id' => $quiz->id,
            'status'  => QuizResult::STATUS_PROCESS
        ));

        if (!$quiz_result)
        {
            $quiz_result = new QuizResult();
            $quiz_result->user_id = Yii::app()->user->id;
            $quiz_result->quiz_id = $quiz->id;
            $quiz_result->save();
        }

        $choices = QuizChoice::model()->with(array('question' => array('with' => 'answers')))->findAll('result_id = ' . $quiz_result->id);
        if (!$choices)
        {
            $choices[] = array();

            $topics_ids = ArrayHelper::extract($quiz->topics_rels, 'topic_id');
            $questions  = QuizQuestion::model()->findAllByAttributes(array('topic_id' => $topics_ids));

            foreach ($questions as $question)
            {
                $quiz_choice = new QuizChoice();
                $quiz_choice->result_id   = $quiz_result->id;
                $quiz_choice->question_id = $question->id;
                $quiz_choice->save() ;
            }

            $choices = QuizChoice::model()->with(array('question' => array('with' => 'answers')))->findAll('result_id = ' . $quiz_result->id);
        }

        $this->render('quiz', array(
            'choices' => $choices
        ));
    }
}
