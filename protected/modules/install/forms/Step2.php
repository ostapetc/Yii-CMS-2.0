<?
return array(
    'activeForm' => array(
        'id' => 'step1',
    ),
    'elements'   => array(
        '<b>Настройки администратора:</b>',
        'admin_email'                 => array('type' => 'text',
                                               'hint' => 'Автоматически создаст пользователя с правами SuperAdmin'),
        'admin_pass'                  => array('type' => 'password'),
        'admin_pass_confirm'          => array('type' => 'password'),
        '<hr/>',
        '<b>Настройки CMS:</b>',
        'modules'                     => array('type'  => 'multi_select', 'items' => Step2::getAvailableModules()),
        'save_site_actions'           => array('type' => 'checkbox'),
        'multilanguage_support'       => array('type' => 'checkbox'),
        'collect_routes_from_modules' => array('type' => 'checkbox'),
        'themes_enabled'              => array('type' => 'checkbox'),
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Продолжить',
            'id'    => 'feedback_button'
        )
    )
);
