<?php

$elements = "";

foreach($this->tableSchema->columns as $column)
{
    if (in_array($column->name, array('user_id', 'date_create')))
    {
        continue;
    }

    if($column->autoIncrement)
    {
        continue;
    }

    $type = 'text';

    if (preg_match("|^varchar\(([0-9]+)\)$|ui", $column->dbType, $size))
    {   
        if ($size[1] > 200)
        {
            $type = "textarea";
        }
    }
    else if (preg_match("|^enum\('active','hidden'\)$|ui", $column->dbType))
    {
        $type = "dropdownlist";
    }
    else if ($column->dbType == 'date')
    {
        $type = 'date';
    }

    $elements.= "        '" . $column->name . "' => array('type' => '" . $type . "'),\n";
}

echo '<?php

return array(
    \'activeForm\' => array(
        \'id\' => \'' . $this->class2id($this->modelClass) . '-form\',
		//\'enableAjaxValidation\' => true,
		//\'clientOptions\' => array(
		//	\'validateOnSubmit\' => true,
		//	\'validateOnChange\' => true
		//)
    ),
    \'elements\' => array(
' . $elements . '
    ),
    \'buttons\' => array(
        \'submit\' => array(
            \'type\'  => \'submit\',
            \'value\' => $this->model->isNewRecord ? \'создать\' : \'сохранить\')
    )
);
';

?>


