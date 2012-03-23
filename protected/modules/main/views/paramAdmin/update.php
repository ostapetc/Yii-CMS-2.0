<?
if ($form->model->scenario == Param::SCENARIO_VALUE_UPDATE)
{
    $this->page_title = 'Редактирование значения параметра';
}
else
{
    $this->page_title = 'Редактирование свойств параметра';
}


$this->tabs = array(
    'Просмотр'      => $this->createUrl('view', array('id' => $form->model->id)),
    'Все параметры' => $this->createUrl('manage')
);
?>

<?= $form ?>