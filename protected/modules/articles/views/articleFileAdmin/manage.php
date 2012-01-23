<h3><?php echo $article->title; ?></h3>

<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/filesManage.js', CClientScript::POS_END);

$this->page_title = "Файлы материала";

$this->tabs = array(
    "материалы" => $this->createUrl('ArticleAdmin/manage'),
    "добавить"  => $this->createUrl('create', array('article_id' => $article->id)),
);

$this->widget('GridView', array(
	'id'=>'article-file-grid',
	'dataProvider'=>$model->search($article->id),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'created_at',
		array(
			'class'=>'CButtonColumn',
            'template' => '{update} {delete}'
		),
	),
));

$this->widget('application.extensions.Plupload.Plupload', array(
    'url' => '/articles/articleFileAdmin/create/article_id/' . $article->id
));
?>
