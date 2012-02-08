<?php

$this->page_title = 'Просмотр роли';

$this->widget('AdminDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'description',
        'bizrule',
        'data'
    )
));
