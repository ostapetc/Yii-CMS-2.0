<?='<?
$this->tabs = array(
    \'добавить ' . $accusative . '\' => $this->createUrl(\'create\')
);

$this->widget(\'AdminGridView\', array(
    \'id\'           => \'' . $class . '-grid' . '\',
    \'dataProvider\' => $model->search(),
    \'filter\'       => $model
));
?>'?>