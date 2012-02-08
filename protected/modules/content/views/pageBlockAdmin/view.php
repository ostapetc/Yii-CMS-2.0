<?php
$this->page_title = t('Просмотр блока страницы');

$this->widget('AdminDetailView', array(
    'data'      => $model,
    'attributes'=> array(
        'title', array(
            'name'  => 'lang',
            'value' => $model->language->name
        ),
        'name',
        'date_create',
        array(
            'name' => 'text',
            'type' => 'raw'
        )
    ),
));
?>
