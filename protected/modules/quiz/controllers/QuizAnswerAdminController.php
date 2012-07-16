<?

class QuizAnswerAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'view'   => t('Просмотр варианта ответа на вопрос'),
            'create' => t('Создание варианта ответа'),
            'update' => t('Редактирование варианта ответа'),
            'delete' => t('Удаление варианта ответа'),
            'manage' => t('Управление вариантами ответов'),
        );
    }

        
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionCreate($question_id)
	{
        $question = QuizQuestion::model()->findByPk($question_id);
        if (!$question)
        {
            $this->pageNotFound();
        }

		$model = new QuizAnswer();
        $model->question_id = $question->id;

		$form  = new Form('quiz.QuizAnswerForm', $model);
		
		$this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
		{
            $this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('create', array(
			'form'     => $form,
            'question' => $question
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
        $form  = new Form('quiz.QuizAnswerForm', $model);

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
		$model = new QuizAnswer('search');
		$model->unsetAttributes();

		if(isset($_GET['QuizAnswer']))
        {
            $model->attributes = $_GET['QuizAnswer'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = QuizAnswer::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}
}
