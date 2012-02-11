<?php
$this->page_title = $this->t('admin', 'manage');

$this->tabs = array(
    $this->t('admin', 'create')  => $this->createUrl("create", array('parent_id'=>1)),
    $this->t('admin', 'sorting') => $this->createUrl("sorting"),
);


$this->widget('content.portlets.TreeGridView', array(
    'id'           => 'category-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'title',
//        array(
//            'type'  => 'raw',
//            'value' => '$data->productsManageLink',
//            'header' => 'Списки товаров'
//        ),
        array(
            'class'   => 'CButtonColumn',
            'template'=> '{add_child}{update}{delete}',
            'buttons' => array(
                'add_child' => array(
                    'imageUrl' => '/img/admin/plus_16.png',
                    'url'      => '$data->addChildUrl',
                    'label'    => 'Добавить подкатегорию'
                ),
            )
        ),
    ),
));