<?php 
$this->page_title = $article->title;

$this->crumbs = array(
	$this->url("/")         => Yii::t('ArticlesModule.main', 'Главная'),
	$this->url("/articles") => Yii::t('ArticlesModule.main', 'База знаний')
);

if ($article->section->parent) 
{
    $this->crumbs[$this->url("/articles/section/{$article->section->parent['id']}")] = $article->section->parent->name;
}

$this->crumbs[$this->url("/articles/section/{$article->section['id']}")] = $article->section->name;

?>

<?php echo $article->content; ?>

<?php if ($article->files): ?>
	<div style="margin-top:30px;margin-bottom:10px;font-weight:bold"><?php echo Yii::t('ArticlesModule.main', 'Файлы для скачивания'); ?>:</div>

	<?php foreach ($article->files as $file): ?>
		<a href='/' class='link_13'><?php echo $file->file ?></a> <br/>
	<?php endforeach ?>
<?php endif ?>




