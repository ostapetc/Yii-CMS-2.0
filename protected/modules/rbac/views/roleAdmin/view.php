<?php

$this->page_title = 'Просмотр роли';

$this->widget('DetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'description',
        'bizrule',
        'data'
    )
));
