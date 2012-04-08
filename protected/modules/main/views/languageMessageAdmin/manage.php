<?

$this->page_title = 'Языковые переводы';

$this->tabs = array(
    'Добавить перевод' => $this->createUrl('create')
);

$config  = AppManager::getConfig();
$columns = array('message');

foreach ($languages as $id => $language)
{
    if ($config['language'] == $id)
    {
        continue;
    }

    $columns[] = array(
        'header' => $language,
        'name'   => "translations[{$id}]",
        'value'  => '$data->translation("'. $id .'")',
        'filter' => false
    );
}

$columns[] = array(
    'class'    => 'CButtonColumn',
    'template' => '{update} {delete}'
);

$this->widget('AdminGridView', array(
	'id'           => 'languages-translations-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
	'columns'      => $columns
));