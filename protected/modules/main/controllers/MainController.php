<?

class MainController extends ClientController
{   
    public static function actionsTitles() 
    {
        return array(
            "error"          => "Ошибка на странице",
            "error404"       => "Страница не найдена",
            "search"         => "Поиск по сайту",
            "changeLanguage" => "Смена языка"
        );
    }


    public function subMenuItems()
    {
        return array(
            array(
                'label'   => 'Сообщить об ошибке',
                'url'     => array('/'),
                'visible' => Yii::app()->controller->action->id == 'error'
            )
        );
    }
    

	public function actionSearch($query) 
	{
	    $models = array(
            "News" => array(
                'attributes' => array("title", "text"),
                'view_path' => 'application.modules.news.views.news._view'
            ),
            "Page" => array(
                'attributes' => array("title", "text"),
                'view_path'  => 'application.modules.content.views.page._view'
            ),
        );
        
        $query = addslashes(strip_tags($query));
        	
	    $result = array();

	    foreach ($models as $class => $data) 
	    {
	        $criteria = new CDbCriteria;
	        
	        foreach ($data['attributes'] as $attribute) 
	        {   
	            $criteria->compare($attribute, $query, true, 'OR');
	        }
	        
	        $model = new $class; 
	        
	        $items = $model->findAll($criteria);
	        if ($items) 
	        {
	            $result[$data['view_path']] = $items;
	        } 
	    }

	    $this->render('search', array(
	        'result' => $result,
	        'query'  => $query
	    ));
	}
    
    
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    	{
	    		echo $error['message'];
	    	}
	    	else
	    	{
	        	$this->render('error', $error);
	        }	
	    }
	}


    public function actionError404()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                echo $error['message'];
            }
            else
            {
                $this->render('error404', $error);
            }
        }
    }

    public function actionChangeLanguage($set_language, $back_url)
    {
        $languages = Language::getList();
        if (!isset($languages[$set_language]))
        {
            throw new CHttpException("Неизвестный системе язык: '{$set_language}'");
        }

        Yii::app()->session['language'] = $set_language;

        $back_url    = explode('/', base64_decode($back_url));
        $back_url[1] = $set_language;
        $back_url    = implode('/', $back_url);

        $this->redirect($back_url);
    }


    public function actionOff()
    {
        echo "site off";
    }
}
