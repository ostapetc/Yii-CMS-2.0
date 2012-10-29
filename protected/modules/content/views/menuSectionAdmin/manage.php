<?
$this->page_title = 'Разделы меню :: ' . $menu->name;

$this->tabs = [
    "управление меню" => $this->createUrl('/content/menuAdmin/manage'),
    "добавить раздел" => $this->createUrl('create', [
        'menu_id' => $menu->id,
        'parent_id' => $root->id,
        'back' => 'manage'
    ]),
    "сортировка" => $this->createUrl('sorting', [
        'root_id' => $root->id,
        'menu_id' => $menu->id
    ]),
];

$this->widget('AdminGridView', [
    'id' => 'menu-section-grid',
    'dataProvider' => $model->search($root->id),
    'filter' => $model,
    'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
    'columns' => [
        [
            'name' => 'title',
            'value' => function ($data)
            {
                return CHtml::link($data->nbsp_title, Yii::app()->controller->createUrl("update", [
                    "id" => $data->id,
                    'back' => 'manage'
                ]), [
                    "level" => $data->level,
                    "class" => "node_link"
                ]);
            },
            'type' => 'raw'
        ],
        'url',
        [
            'header' => 'Принадлежность',
            'type' => 'raw',
            'value' => function($data, $row)
            {
                $img_url = Yii::app()->getModule('content')->assetsUrl() . '/img';

                $src = '';
                $htmlOptions = [];

                if ($data->page_id)
                {
                    $src = $img_url . '/page.png';
                    $htmlOptions['title'] = 'Привязка к странице: ' . $data->title;
                }
                elseif ($data->module_url)
                {
                    $src = $img_url . '/module.png';

                    $modules_urls = AppManager::getModulesClientMenu();
                    if (isset($modules_urls[$data->module_id][$data->module_url]))
                    {
                        $htmlOptions['title'] = 'Привязка к модулю: ' . $modules_urls[$data->module_id][$data->module_url];
                    }
                    else
                    {
                        $htmlOptions['title'] = 'Неверная привязка к несуществующему разделу модуля!';
                        $htmlOptions['style'] = 'border:2px dashed red';
                    }
                }

                if ($src)
                {
                    return CHtml::image($src, $htmlOptions['title'], $htmlOptions);
                }
            },
            'htmlOptions' => ['width' => '1px']
        ],
        [
            'class' => 'PublishedColumn',
            'name'  => 'is_published'
        ],
        [
            'class' => 'CButtonColumn',
            'template' => '{create} {update} {delete}',
            'buttons' => [
                'create' => [
                    'label' => 'добавить дочерний раздел',
                    'imageUrl' => '/img/admin/child.png',
                    'url' => 'Yii::app()->controller->createUrl("create",["menu_id" => $data->menu->id, "parent_id" => $data->id, "back" => "manage"])'
                ],
                'update' => [
                    'url' => 'Yii::app()->controller->createUrl("update",["id" => $data->id, "back" => "manage"])'
                ]
            ]
        ],
    ],
]);




