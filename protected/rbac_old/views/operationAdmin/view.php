<?
$this->page_title = 'Просмотр операции';

$this->widget('BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'description',
        array('name' => 'allow_for_all', 'value' => $model->allow_for_all ? 'Да' : 'Нет'),
        'bizrule',
        'data'
    )
));
