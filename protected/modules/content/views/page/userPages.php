<? if ($widget == 'list'): ?>
    <?
    $this->widget('ListView', [
        'id'           => 'Page-listView',
        'dataProvider' => $data_provider,
        'summaryText'  => '',
        'itemView'     => '_view',
        'viewData'     => ['preview' => true],
    ]);
    ?>
<? else: ?>
    <?=
    $this->widget('BootGridView', [
        'id'           => 'email-template-grid',
        'dataProvider' => $data_provider,
        'filter'       => $model,
        'columns' => [
            'title',
            [
                'name'   => 'status',
                'value'  => '$data->value("status")',
                'filter' => Page::$status_options
            ],
            'date_create',
            [
                'class'=>'BootButtonColumn',
            ],
        ],
    ])
    ?>
<? endif ?>

