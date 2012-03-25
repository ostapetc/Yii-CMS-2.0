<?
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<? echo "<?\n"; ?>

class <? echo $modelClass; ?> extends <? echo $this->baseClass."\n"; ?>
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return '<? echo $tableName; ?>';
	}


    public function name()
    {
        return 'Модель <? echo $modelClass; ?>';
    }


	public function rules()
	{
		return array(
<? foreach($rules as $rule): ?>
			<? echo $rule.",\n"; ?>
<? endforeach; ?>

			array('<? echo implode(', ', array_keys($columns)); ?>', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
<? foreach($relations as $name => $relation): ?>
			<? echo "'$name' => $relation,\n"; ?>
<? endforeach; ?>
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
<?
foreach($columns as $name => $column)
{
	if($column->type==='string')
	{
		echo "\t\t\$criteria->compare('$name', \$this->$name, true);\n";
	}
	else
	{
		echo "\t\t\$criteria->compare('$name', \$this->$name);\n";
	}
}
?>

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}