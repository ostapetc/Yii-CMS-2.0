<?php
Yii::app()->clientScript->registerScriptFile('/js/site/articles.js');

if (!$articles) 
{
    echo $this->msg(Yii::t('ArticlesModule.main', 'Не найдены материалы данного раздела'), 'info');
}

if (!$this->crumbs) 
{
    $this->crumbs = array(
        $this->url("/")         => Yii::t('ArticlesModule.main', 'Главная'),
        $this->url("/articles") => Yii::t('ArticlesModule.main', 'База знаний')
    );
}

$this->page_title = Yii::t('ArticlesModule.main', 'База знаний');
?>

<?php if ($sections): ?>
    <?php $this->beginWidget('system.web.widgets.CClipWidget', array('id' => 'articles_search')); ?>
        <div id="ex_search">
            <form action="">
                <table border="0" width="100%">
                    <tr valign='top'>
                        <td>
                            <select class="ex_select" id="sections_select">
                                <option><?php echo Yii::t('ArticlesModule.main', 'выбор категории'); ?></option>
                                <?php foreach ($sections as $section): ?>
                                    <option value='<?php echo $section->id; ?>'><?php echo $section->name; ?></option>
                                <?php endforeach ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" value="<?php echo Yii::t('ArticlesModule.main', 'Ищете что то еще?'); ?>" class="ex_text" id="article_query" />
                        </td>
                        <td>
                            <input type="button" value="<?php echo Yii::t('ArticlesModule.main', 'Найти'); ?>" class="ex_search_button" id="article_search_button" />
                        </td>
                    </tr>
                    <tr valign='top'>
                        <td>
                            <select class="ex_select" id="subsections_select">
                                <option><?php echo Yii::t('ArticlesModule.main', 'выбор подкатегории'); ?></option>
                            </select>
                        </td>
                        <td style="text-align:center">
                            <img src='/images/site/loader.gif' id="img_loader" border='0'/>
                        </td>
                    </tr>
                </table>
            </form>
        </div><br/>
    <?php $this->endWidget();?>
<?php endif; ?>

<div id="articles_content">
        
    <?php $this->renderPartial('application.modules.articles.views.article._list', array('articles' => $articles)); ?>    
        
    <?php $this->renderPartial('application.views.layouts.pagination', array('pages' => $pages)); ?>

</div>

