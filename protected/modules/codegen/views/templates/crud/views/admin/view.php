<?='<?
$this->tabs = array(
    \'управление ' . $instrumental . '\'  => $this->createUrl(\'manage\'),
    \'редактировать\' => $this->createUrl(\'update\', array(\'id\' => $model->id))
);

$this->widget(\'AdminDetailView\', array(
    \'data\' => $model
));
?>'?>