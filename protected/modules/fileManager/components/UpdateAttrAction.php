<?php
class UpdateAttrAction extends BaseFilesApiAction
{
    public function run($id)
    {
        $model = $this->controller->loadModel($id);

        $model->scenario = 'update';

        $this->controller->performAjaxValidation($model);
        $attr = $_POST['attr'];
        if (isset($_POST[$attr]))
        {
            $model->$attr = trim(strip_tags($_POST[$attr]));

            if ($model->save(false))
            {
                echo $model->$attr;
            }
        }
    }
}