<?php

class NewsController extends BaseController
{
	public static function actionsTitles() 
	{
	    return array(
	        "View"  => "Просмотр новости",
	        "Index" => "Список новостей",
	        "Mark" => "Список новостей",
	    );
	}
	
	
	public function actionView($id) 
	{
        $this->render('view', array(
			'model'      => $this->loadModel($id, array('published'))
		));	
	}
	
	public function actionIndex() 
	{
        $model = News::model();
        $data_provider = new ActiveDataProvider(get_class($model), array(
            'criteria' => $model->published()->last()->getDbCriteria(),

            'pagination'=>array(
                'pageSize'=>2
            )
        ));

		$this->render('index', array(
            'data_provider' => $data_provider
		));
	}

}


