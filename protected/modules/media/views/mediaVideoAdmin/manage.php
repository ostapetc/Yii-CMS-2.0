<?
$this->tabs = array(
    'Добавить страницу' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id'           => 'page-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
	'columns' => array(
        array(
            'value' => '"<iframe src=".$data->player_url."></iframe>"',
            'type' => 'raw'
        ),
        array(
            'name' => 'title',
            'type' => 'raw'
        ),
        array(
            'header' => 'Рейтинги',
            'value' => '"Показы: ".$data->view_count."<br/>Проголосовало: ".$data->raters."<br/>Рейтинг: ".$data->average',
            'type' => 'raw'
        ),
        array(
            'header' => 'Автор',
            'value' => 'CHtml::link($data->author_name, $data->author_uri, array("target"=>"_blank"))',
            'type' => 'raw'
        ),
        array(
            'header' => 'Категории',
            'value' => 'implode("\\n", $data->categories)',
            'type' => 'raw'
        ),
	),
));
?>




