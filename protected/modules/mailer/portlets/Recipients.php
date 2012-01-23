<?php
 
class Recipients extends Portlet
{
    public $users;

    
    public function renderContent()
    {
        if (!$this->users)
        {
            return;
        }

        $grouped_users = array();

        foreach ($this->users as $user)
        {
            if (!isset($grouped_users[$user->role->description]))
            {
                $grouped_users[$user->role->description] = array();
            }

            $grouped_users[$user->role->description][] = $user->name;
        }

        $this->render('Recipients', array('grouped_users' => $grouped_users));
    }
}
