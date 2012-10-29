<?php

class UpdatePageAction extends CAction
{
    public function run($id)
    {
        $model = $this->loadModel($id);
        $form  = new Form('content.PageForm', $model);

        //$this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->controller->redirect(['view', 'id'=> $model->id)];
        }

        $this->controller->render('update', [
            'form' => $form
        ]);
    }
}
