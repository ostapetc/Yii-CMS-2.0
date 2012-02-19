<?php

$this->page_title = 'Языковые переводы';

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
        'value'  => '$data->translation("'. $id .'")'
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