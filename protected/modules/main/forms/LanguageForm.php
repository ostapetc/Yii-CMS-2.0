<?

$assets_url = Yii::app()->controller->module->assetsUrl();

$cs = Yii::app()->clientScript;
$cs->registerCssFile($assets_url . '/css/LanguageForm.css');
$cs->registerScriptFile($assets_url . '/js/LanguageForm.js');

$dir = $_SERVER['DOCUMENT_ROOT'] . 'img/icons/flags/';
$ids = array();

$files = scandir($dir);
foreach ($files as $file)
{
    if ($file[0] == '.')
    {
        continue;
    }

    $ids[] = array_shift(explode('.', $file));
}

$id_disabled = false;
if (!$this->model->isNewRecord)
{
    $config = AppManager::getConfig();
    if ($config['language'] == $this->model->id)
    {
        $id_disabled = true;
    }
}

return array(
    'activeForm' => array(
        'id'                   => 'language-form',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'id'   => array(
            'type'     => 'dropdownlist',
            'items'    => array_combine($ids, $ids),
            'prompt'   => 'не выбран',
            'disabled' => $id_disabled
        ),
        'name' => array('type' => 'text'),
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Добавить' : 'Сохранить'
        )
    )
);
