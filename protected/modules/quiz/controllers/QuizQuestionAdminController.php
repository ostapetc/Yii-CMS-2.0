<?

class QuizQuestionAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'view'   => 'Просмотр вопроса тестирования',
            'create' => 'Создание вопроса тестирования',
            'update' => 'Редактирование вопроса тестирования',
            'delete' => 'Удаление вопроса тестирования',
            'manage' => 'Управление вопросами тестирования',
        );
    }

        
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionCreate($topic_id = null)
	{
        $model = new QuizQuestion();

        if ($topic_id)
        {
            $topic = QuizTopic::model()->findByPk($topic_id);
            if (!$topic)
            {
                $this->pageNotFound();
            }

            $model->topic_id = $topic->id;
        }

		$form = new Form('quiz.QuizQuestionForm', $model);
		
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
        $form  = new Form('quiz.QuizQuestionForm', $model);

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
		$model = new QuizQuestion('search');
		$model->unsetAttributes();

		if(isset($_GET['QuizQuestion']))
        {
            $model->attributes = $_GET['QuizQuestion'];

            if (isset($_GET['QuizQuestion']['topic_id']) && is_numeric($_GET['QuizQuestion']['topic_id']))
            {
                $topic = QuizTopic::model()->findByPk($_GET['QuizQuestion']['topic_id']);
                if (!$topic)
                {
                    $this->pageNotFound();
                }
            }
        }

		$this->render('manage', array(
			'model' => $model,
            'topic' => isset($topic) ? $topic : null
		));
	}


	public function loadModel($id)
	{
		$model = QuizQuestion::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}
}
