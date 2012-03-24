<?php

$this->page_title = 'Просмотр роли';

$this->widget('BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'description',
        'bizrule',
        'data'
    )
));
