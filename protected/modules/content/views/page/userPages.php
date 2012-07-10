<? if ($widget == 'list'): ?>
    <?
    $this->widget('ListView', array(
        'id'           => 'Page-listView',
        'dataProvider' => $data_provider,
        'summaryText'  => '',
        'itemView'     => '_view',
        'viewData'     => array('preview' => true),
    ));
    ?>
<? else: ?>
    <?=
    $this->widget('BootGridView', array(
        'id'           => 'email-template-grid',
        'dataProvider' => $data_provider,
        'filter'       => $model,
        'columns' => array(
            'title',
            array(
                'name'   => 'status',
                'value'  => '$data->value("status")',
                'filter' => Page::$status_options
            ),
            'date_create',
            array(
                'class'=>'BootButtonColumn',
            ),
        ),
    ))
    ?>
<? endif ?>

