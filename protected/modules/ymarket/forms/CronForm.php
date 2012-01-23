<?php

return array(
    'activeForm' => array(
        'id' => 'ymarket-cron-form',
    ),
    'elements' => array(
        'name'      => array('type' => 'text'),
        'interval'  => array('type' => 'text'),
        'priority'  => array('type' => 'dropdownlist', 'items' => array_combine(range(1, 4), range(1, 4))),
        'is_active' => array('type' => 'checkbox'),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Сохранить'
        )
    )
);