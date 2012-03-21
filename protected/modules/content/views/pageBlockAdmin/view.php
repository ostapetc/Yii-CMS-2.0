<?php
$this->page_title = t('Просмотр блока страницы');

$this->tabs = array(
    'редактивать' => $this->createUrl('update', array('id' => $model->id)),
    'все блоки'   => $this->createUrl('manage')
);

$this->widget('BootDetailView', array(
    'data'      => $model,
    'attributes'=> array(
        'title', array(
            'name'  => 'language',
            'value' => $model->language_model->name
        ),
        'constant',
        'date_create',
        array(
            'name' => 'text',
            'type' => 'raw'
        )
    ),
));
?>
