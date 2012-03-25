<?
/**
 * This is the template for generating the action script for the form.
 * - $this: the CrudCode object
 */
?>
<?
$viewName=basename($this->viewName);
?>
public function action<? echo ucfirst(trim($viewName,'_')); ?>()
{
    $model=new <? echo $this->modelClass; ?><? echo empty($this->scenario) ? '' : "('{$this->scenario}')"; ?>;

    // uncomment the following code to enable ajax-based validation
    /*
    if(isset($_POST['ajax']) && $_POST['ajax']==='<? echo $this->class2id($this->modelClass); ?>-<? echo $viewName; ?>-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }
    */

    if(isset($_POST['<? echo $this->modelClass; ?>']))
    {
        $model->attributes=$_POST['<? echo $this->modelClass; ?>'];
        if($model->validate())
        {
            // form inputs are valid, do something here
            return;
        }
    }
    $this->render('<? echo $viewName; ?>',array('model'=>$model));
}