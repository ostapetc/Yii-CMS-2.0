<?

class QuizModule extends WebModule
{
    public static $active = true;


    public static function name()
    {
        return 'Тестирование';
    }


    public static function description()
    {
        return 'Тестирование';
    }


    public static function version()
    {
        return '1.0';
    }


    public function init()
    {
        $this->setImport(array(
            'quiz.models.*',
            'quiz.portlets.*',
        ));
    }


    public static function adminMenu()
    {
        return array(
            t('Тесты')                 => Yii::app()->createUrl('/quiz/quizAdmin/manage'),
            t('Создать тест')           => Yii::app()->createUrl('/quiz/quizAdmin/create'),
            t('Тематики')              => Yii::app()->createUrl('/quiz/quizTopicAdmin/manage'),
            t('Создать тематику')       => Yii::app()->createUrl('/quiz/quizTopicAdmin/create'),
            t('Вопросы')               => Yii::app()->createUrl('/quiz/quizQuestionAdmin/manage'),
            t('Создать вопрос')         => Yii::app()->createUrl('/quiz/quizQuestionAdmin/create'),
            t('Варианты ответов')       => Yii::app()->createUrl('/quiz/quizAnswerAdmin/manage'),
            t('Добавить вариант ответа') => Yii::app()->createUrl('/quiz/quizAnswerAdmin/create'),
        );
    }


    public static function routes()
    {
        return array(

        );
    }
}
