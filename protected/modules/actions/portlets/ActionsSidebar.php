<?php

class ActionsSidebar extends Portlet
{
    public function renderContent()
    {
        $this->render('ActionsSidebar', array(
            'actions' => Action::model()->limit(2)->findAll(array('order' => 'date DESC'))
        ));
    }
}
