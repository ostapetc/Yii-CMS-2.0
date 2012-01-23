<?php

class ActionController extends BaseController 
{	
	const PAGE_SIZE = 10;

    
    public static function actionsTitles() 
    {
        return array(
            "Index" => "Просмотр списка мероприятий",
            "View"  => "Просмотр мероприятия"
        );
    }
    
    
	public function actionIndex() 
	{	
		$model = Action::model();
		
		$criteria = $model->dbCriteria;
		$criteria->order = 'date DESC';

		$paginator = new CPagination($model->count($criteria));
		$paginator->pageSize = self::PAGE_SIZE;		
		$paginator->applyLimit($criteria);
		
		$actions = $model->findAll($criteria);		

		$this->render('index', array(
			'actions' => $actions,
			'pages'   => $paginator 
		));
	}


	public function actionView($id) 
	{   
		$action = Action::model()->findByPk($id);
		if (!$action) 
		{
			$this->pageNotFound();
		}
		
		$this->render('view', array('action' => $action));
	}
}
