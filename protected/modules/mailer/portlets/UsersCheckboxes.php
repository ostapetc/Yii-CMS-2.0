<?php
 
class UsersCheckboxes extends InputWidget
{	
	public $model;
	
	
    public function renderContent()
    {		
		$users_ids = array();

        if (isset($this->model->template) && $this->model->template)
        {
            $recipients = $this->model->template->recipients;
        }
        else
        {
            $recipients = $this->model->recipients;
        }

		foreach ($recipients as $recipient)
		{
			$users_ids[] = $recipient->user_id; 	
		} 	
    	
        $this->render('UsersCheckboxes', array(
            'users_ids' => $users_ids,
        	'roles'     => AuthItem::model()->roles
        ));
    }
}
