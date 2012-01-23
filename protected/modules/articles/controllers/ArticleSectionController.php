<?php 

class ArticleSectionController extends BaseController 
{   
    public static function actionsTitles() 
    {
        return array(
            "GetChilds" => "Получить подразделы"
        );
    }


    public function actionGetChilds($id) 
    {
        if (!$this->request->isAjaxRequest) 
        {
            return;
        }    
    
        $sections = ArticleSection::model()->findAllByAttributes(
            array('parent_id' => $id),
            array('order' => 'name')
        );
        
        echo CJSON::encode($sections);
    }    
}
