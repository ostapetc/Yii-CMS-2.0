<?
/**
 * This is the template for generating a controller class file.
 * The following variables are available in this template:
 * - $this: the ControllerCode object
 */
?>
<? echo "<?\n"; ?>

class <? echo $this->controllerClass; ?> extends <? echo $this->baseClass."\n"; ?>
{
<? foreach($this->getActionIDs() as $action): ?>
	public function action<? echo ucfirst($action); ?>()
	{
		$this->render('<? echo $action; ?>');
	}

<? endforeach; ?>
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}