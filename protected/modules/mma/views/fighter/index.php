<?
$this->widget('BootGridView', array(
    'dataProvider' => $data_provider,
    'filter'       => new Fighter(),
    'columns' => array(
        array(
            'name'  => 'image',
            'value' => '$data->image'
        ),
        array(
            'name'  => 'name',
            'value' => '$data->name'
        ),
        array(
            'name'  => 'nickname',
            'value' => '$data->nickname'
        ),
        'weight',
        'height',
    )
));