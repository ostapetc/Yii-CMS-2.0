<?php 
if (!$articles) 
{
    echo $this->msg(Yii::t('ArticlesModule.main', 'Не найдены материалы данного раздела'), 'info');
}

if (!$this->crumbs) 
{
    $this->crumbs = array(
            "/"         => Yii::t('ArticlesModule.main', 'Главная'),
            "/articles" => Yii::t('ArticlesModule.main', 'База знаний')
    );
    
    if ($section->parent) 
    {
        $this->crumbs["/articles/section/{$section->parent->id}"] = $section->parent->name;
    }
    
    $this->crumbs[""] = $section->name;
}

$this->page_title = Yii::t('ArticlesModule.main', 'База знаний');
?>


<?php $this->renderPartial('application.modules.articles.views.article._list', array('articles' => $articles)); ?>    
    
<?php $this->renderPartial('application.views.layouts.pagination', array('pages' => $pages)); ?>
