<?php
 
class FaqSectionController extends BaseController
{   
    public static function actionsTitles() 
    {
        return array(
            "Index" => "Просмотр разделов вопросов"
        );    
    }


    public function actionIndex()
    {
        $sections_with_questions = false;    
            
        $sections = FaqSection::model()->published()->findAll();
        foreach ($sections as $i => $section) 
        {
            if ($section->faqs) 
            {
                $has_published = false;
                
                foreach ($section->faqs as $faq) 
                {
                    if ($faq->is_published) 
                    {
                        $has_published = true;
                        break;    
                    }
                }
                
                if ($has_published) 
                {
                    $sections_with_questions[] = $section;
                }
            }
        }    
        
        if ($sections_with_questions && count($sections_with_questions) == 1)
        {
            $this->redirect($this->url("/faq/section/" . $sections_with_questions[0]->id));
        }
            
        $this->render('index', array(
            'sections' => $sections_with_questions
        ));
    }
}
