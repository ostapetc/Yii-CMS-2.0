<?php

class FeedbackPortlet extends Portlet
{
    public function renderContent()
    {
        $model = new Feedback();
        $form  = new BaseForm('feedback.FeedbackForm', $model);

        $this->render('FeedbackPortlet', array(
            'form' => $form
        ));
    }
}
