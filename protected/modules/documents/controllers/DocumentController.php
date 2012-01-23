<?php

class DocumentController extends BaseController 
{
	const PAGE_SIZE = 10;	
    
    
    public static function actionsTitles() 
    {
        return array(
            "Index" => "Просмотр списка документов",
            "View"  => "Просмотр документа"
        );
    }
    

	public function actionIndex() 
	{
		$model = Document::model()->published();

		$criteria = $model->dbCriteria;
		$criteria->order = 'date_publish DESC';

		$paginator = new CPagination($model->count($criteria));
		$paginator->pageSize = self::PAGE_SIZE;
		$paginator->applyLimit($criteria);

		$documents = $model->findAll($criteria);		

		$this->render('index', array(
			'documents' => $documents,
			'pages'     => $paginator
		));
	}


	public function actionView($id) 
	{
		$document = Document::model()->published()->findByPk($id);
		if (!$document) 
		{
			$this->pageNotFound();
		}

		$this->render('view', array('document' => $document));
	}
}

