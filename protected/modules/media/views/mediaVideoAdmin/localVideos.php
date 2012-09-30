<?
$widget = $this->widget('AdminGridView', array(
    'id'           => 'non-moderated-grid',
    'dataProvider' => $dp,
//    'filter'       => $model,
    'columns'      => array(
        array(
            'name' => 'title',
            'type' => 'raw'
        ),

    ),
));
