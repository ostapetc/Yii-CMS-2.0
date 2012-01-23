<?php

class ArticleController extends BaseController 
{   
    const PAGE_SIZE = 10;


    public static function actionsTitles() 
    {
        return array(
            "Index"           => "Просмотр списка статей",
            "View"            => "Просмотр статьи",
            "Search"          => "Поиск статей",
            "SectionArticles" => "Просмотр статей раздела"
        );
    }    
    
    
    public function actionIndex() 
    {
        $model = Article::model();

        $criteria = $model->dbCriteria;     
        $criteria->order = 'date DESC';

        $pages = new CPagination($model->count($criteria));
        $pages->pageSize = self::PAGE_SIZE;
        $pages->applyLimit($criteria);
            
        $articles = $model->findAll($criteria);    

		$sections = ArticleSection::model()->findAllByAttributes(
			array('parent_id' => null),
			array('order' => 'name')
		);	       	
     
        $this->render('index', array(
            'articles' => $articles,
			'sections' => $sections,
            'pages'    => $pages
        ));      
    }
    
    
    public function actionView($id) 
    {   
        $article = Article::model()->findByPk($id); 
        if (!$article) 
        {
            $this->pageNotFound();
        }
        
        $this->render('view', array('article' => $article));
    }
    
    
    public function actionSearch() 
    {       
        if (!$this->request->isAjaxRequest) 
        {   
            return;
        }
        
        $criteria = new CDbCriteria();
      
        if (isset($_POST['section_id'])) 
        {   
            $section = ArticleSection::model()->findByPk((int) $_POST['section_id']);   
       
            if (!$section) 
            {  
                return;
            }
            
            $secttion_ids = array($section->id);  
            
            if ($section->childs) 
            {
                foreach ($section->childs as $child) 
                {
                    $secttion_ids[] = $child->id;
                }
            }  
            
            $criteria->addInCondition("section_id", $secttion_ids);                     
        }      
        
        if (isset($_POST['query'])) 
        {
            $query = $_POST['query'];    
            
            $criteria->addCondition("`title` LIKE '%{$query}%' OR `text` LIKE '%{$query}%'"); 
        }
      
        $articles = Article::model()->findAll($criteria, array('order' => 'date DESC', 'limit' => 10));
        
        if ($articles) 
        {
            $html = $this->renderPartial('application.modules.articles.views.article._list', array('articles' => $articles), true);
            
            if (isset($section)) 
            {
                $url = $this->url("/articles/section/{$section->id}");

                $html.= "<br/><br/>
                         <div style='text-align:center'>
                            <a href='{$url}'>Все материалы данного раздела</a>
                         </div>
                         <br/>";
            } 
            
            echo $html;       
        }
        else 
        {           
            if (isset($section) && isset($query)) 
            {
                $url = $this->url("/articles/section/{$section->id}");
                $msg = "В разделе <a class='link_13' href='{$url}'>{$section->name}</a>
                        по запросу '{$query}' ничего не найдено.
                        <br/><br/>
                        Попробуйте <a href='#' id='search_link'>осущест$urlить поиск по всей Базе знаний.</a>";
            }
            elseif (isset($section)) 
            {
                $url = $this->url("/articles/section/{$section->id}");
                $msg = "В разделе <a class='link_13' href='{$url}'>{$section->name}</a>
                        ничего не найдено.";                
            }
            else if (isset($query)) 
            {
                $msg = "по запросу '{$query}' ничего не найдено.";                
            }
            
            echo $msg;
        }
    }  
    
    
    public function actionSectionArticles($section_id) 
    {  
        $section = ArticleSection::model()->findByPk($section_id);
        if (!$section) 
        {
            $this->pageNotFound();
        }
            
        $section_ids = array($section->id);    
           
        if ($section->childs) 
        {
            foreach ($section->childs as $child) 
            {
                $section_ids[] = $child->id;    
            }
        }   
        
        $section_ids = implode(',', $section_ids);
            
        $model = Article::model();
        
        $criteria = $model->dbCriteria;
        $criteria->condition = "section_id IN ({$section_ids})";
        $pages = new CPagination($model->count($criteria));
        $pages->pageSize = self::PAGE_SIZE;
        $pages->applyLimit($criteria);
        
        $articles = $model->findAll($criteria);
        
        $this->render('SectionArticles', array(
            'articles' => $articles,
            'section'  => $section,
            'pages'    => $pages
        ));
    }  
}
