<? echo "<?\n"; ?>

return array(
<? if ($upload): ?>
    'enctype'    => 'multipart/form-data',
<? endif ?>
    'activeForm' => array(
        'id'                   => '<?= lcfirst($class) ?>-form',
        'enableAjaxValidation' => true,
        'clientOptions'        => array(
            'validateOnSubmit'=> true
        ),
    ),
    'elements'  => array(
<? foreach ($elements as $name => $data): ?>
        '<?= $name ?>' => array(
            'type' => '<?= $data['type'] ?>',
<? if ($data['type'] == 'dropdownlist'): ?>
            'items' => <?= $data['items'] ?>,
            'empty' => '<?= $data['empty'] ?>',
<? endif ?>
        ),
<? endforeach ?>
    ),
    'buttons'   => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);

