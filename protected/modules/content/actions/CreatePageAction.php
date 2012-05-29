<?php

class CreatePageAction extends CAction
{
    public $layout;


    public function run()
    {
        $this->controller->layout = $this->layout;

        $model = new Page(ActiveRecord::SCENARIO_CREATE);
        $form  = new Form('content.PageForm', $model);

        //$this->getController()->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->controller->redirect(array(
                'view',
                'id' => $model->id
            ));
        }

        $this->controller->render('create', array(
            'form' => $form
        ));
    }
}
