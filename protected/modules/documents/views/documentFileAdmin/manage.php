<?php
$this->page_title = "Файлы документа";

$this->tabs = array(
    "документы" => $this->createUrl('DocumentAdmin/manage'),
    "добавить"  => $this->createUrl('create', array('document_id' => $document->id)),
);
?>

<h3><?php echo $document->name; ?></h3>

<?php
$this->widget('GridView', array(
	'id'=>'document-file-grid',
	'dataProvider'=>$model->search($document->id),
	'filter'=>$model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns'=>array(
		'title',
		array(
			'name'  => 'file',
			'value' => '"<a href=\'/" . DocumentFile::FILES_DIR . $data->file . "\'>скачать</a>";',
			'type'  => 'raw'
 		),
		'created_at',
		array(
			'class'=>'CButtonColumn',
            'template' => '{update} {delete}'
		),
	),
)); 
?>
