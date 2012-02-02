<?php
$this->page_title = 'Просмотр блока страницы';

$this->tabs = array(
    $this->t('admin', 'manage') => $this->createUrl('manage'),
    $this->t('admin', 'update') => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
    'data'      => $model,
    'attributes'=> array(
        'title', array(
            'name'  => 'lang',
            'value' => $model->language->name
        ), 'name', 'date_create', array(
            'name' => 'text',
            'type' => 'raw'
        )
    ),
));
?>
