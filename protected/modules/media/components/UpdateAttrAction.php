<?php
class UpdateAttrAction extends CAction
{
    public $attributes = [];
    public $model;

    public function run($id)
    {
        $model = $this->model ? ActiveRecord::model($this->model)->findByPk($id) : $this->controller->loadModel($id);
        $model->scenario = 'update';
        $this->controller->performAjaxValidation($model);
        $attr = $_POST['attr'];
        if (isset($_POST[$attr]) && in_array($attr , $this->attributes))
        {
            $model->$attr = trim(strip_tags($_POST[$attr]));

            if ($model->save(false))
            {
                echo $model->$attr;
            }
        }
    }
}