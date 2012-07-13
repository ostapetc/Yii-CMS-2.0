<?

class QuizTopicAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'view'   => 'Просмотр тематики',
            'create' => 'Создание тематики',
            'update' => 'Редактирование тематики',
            'delete' => 'Удаление тематики',
            'manage' => 'Управление тематиками',
            'parse'  => 'Парсинг теста'
        );
    }

        
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionCreate()
	{
		$model = new QuizTopic();
		$form  = new Form('quiz.QuizTopicForm', $model);
		
		$this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
		{
            $this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('create', array(
			'form' => $form,
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
        $form  = new Form('quiz.QuizTopicForm', $model);

	    $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
		{
            $this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('update', array(
			'form' => $form,
		));
	}


	public function actionDelete($id)
	{
        $this->loadModel($id)->delete();

        if(!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
	}


	public function actionManage()
	{
		$model = new QuizTopic('search');
		$model->unsetAttributes();

        if (isset($_GET['quiz_id']))
        {
            $quiz = Quiz::model()->findByPk($_GET['quiz_id']);
            if (!$quiz)
            {
                $this->pageNotFound();
            }

            $model->quiz_id = $quiz->id;

            $this->page_title = t('Тематики теста' . ': ' . $quiz->name);
        }

		if(isset($_GET['QuizTopic']))
        {
            $model->attributes = $_GET['QuizTopic'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = QuizTopic::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


    public function actionParse()
    {
        QuizQuestion::model()->deleteAll();
        QuizTopic::model()->deleteAll('id <> 1');

        $links = array(
            'PHP Programming Basics' => 'http://koduleht.eu/phpzendtest/taketest.php?1',
            'Object-oriented Programming with PHP 4' => 'http://koduleht.eu/phpzendtest/taketest.php?2',
            'PHP as a Web Development Language' => 'http://koduleht.eu/phpzendtest/taketest.php?3',
            'Working with Arrays' => 'http://koduleht.eu/phpzendtest/taketest.php?4',
            'Strings and Regular Expressions' => 'http://koduleht.eu/phpzendtest/taketest.php?5',
            'Manipulating Files and the Filesystem' => 'http://koduleht.eu/phpzendtest/taketest.php?6',
            'Date and Time Management' => 'http://koduleht.eu/phpzendtest/taketest.php?7',
            'E-mail Handling and Manipulation' => 'http://koduleht.eu/phpzendtest/taketest.php?8',
            'Database Programming with PHP' => 'http://koduleht.eu/phpzendtest/taketest.php?9',
            'Stream and Network Programming' => 'http://koduleht.eu/phpzendtest/taketest.php?10',
            'Writing Secure PHP Applications' => 'http://koduleht.eu/phpzendtest/taketest.php?11',
            'Debugging Code and Managing Performance' => 'http://koduleht.eu/phpzendtest/taketest.php?12'

        );

        foreach ($links as $topic_name => $url)
        {
            //if ($topic_name != 'Manipulating Files and the Filesystem') continue;

            $topic = new QuizTopic();
            $topic->parent_id = 1;
            $topic->name = trim($topic_name);
            $topic->save();

            $c = file_get_contents($url);
            $c = iconv('ISO-8859-1', 'utf-8', $c);

            $doc = new DOMDocument();
            $doc->encoding = 'UTF-8';
            $doc->loadHTML($c);

            $xpath = new DOMXPath($doc);

            $query = $xpath->query('//div[@class="qbox"]');
            foreach ($query as $i => $div)
            {
                $div_content = $doc->saveXML($div);

                preg_match('|<h4>(.*?)</h4>|is', $div_content, $question);
                $question = trim($question[1]);

                //if ($i != 1) continue;

                $q = new QuizQuestion();
                $q->text = $question;
                $q->topic_id = $topic->id;
                if (!$q->save())
                {
                    v($q->errors);
                    die;
                }

                preg_match_all('|<label for="[0-9a-zA-z]+">(.*?)</label>|is', $div_content, $answers);
                $answers = $answers[1];
                if ($answers)
                {
                    foreach ($answers as $answer)
                    {
                        $answer = trim($answer);

                        $a = new QuizAnswer();
                        $a->question_id = $q->id;
                        $a->text = $answer;
                        if (!$a->save())
                        {
                            v($a->errors);
                            die;
                        }
                    }
                }
                else
                {
                    $a = new QuizAnswer();
                    $a->question_id = $q->id;
                    $a->text = 'Ваш ответ';
                    $a->is_free = 1;
                    if (!$a->save())
                    {
                        v($a->errors);
                        die;
                    }
                }
            }
        }
    }
}
