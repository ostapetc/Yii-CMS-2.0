<?php
$this->page_title = t('Управление блоками страниц');

$this->tabs = array(
    t('Добавить контентный блок') => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
    'id'          => 'page-part-grid',
    'dataProvider'=> $model->search(),
    'filter'      => $model,
    'columns'     => array(
        'title',
        'constant',
        array(
            'name' => 'text',
//            'type' => 'raw'
        ),
        array(
            'name'  => 'language',
            'value' => function ($data) {
                $languages = Language::getCachedArray();
                return $languages[$data->language];
            }
        ),
        'date_create', array(
            'class'=> 'CButtonColumn',
        ),
    ),
));
?>
