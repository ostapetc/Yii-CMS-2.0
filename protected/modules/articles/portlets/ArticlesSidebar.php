<?php

class ArticlesSidebar extends Portlet 
{
	public function renderContent() 
	{	
		$section = ArticleSection::model()->findByAttributes(array('in_sidebar' => 1));		
		if (!$section) 
		{
			return;	
		}		

		$articles = Article::model()->last()->limit(3)->findAllByAttributes(array('section_id' => $section->id));
        if (!$articles) 
        {
            return;
        }
  
		$this->render('ArticlesSidebar', array(
			'section'  => $section,
			'articles' => $articles
		));
	}
}
