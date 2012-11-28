<?php

/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 17.09.12
 * Time: 15:43
 * To change this template use File | Settings | File Templates.
 */

class UserFilterSidebar extends Portlet
{
    public function renderContent()
    {
        $model = new User(User::SCENARIO_USER_SEARCH);
        $model->unsetAttributes();

        if (isset($_GET['User']))
        {
            $model->attributes = $_GET['User'];
        }

        $this->render('UserFilterSidebar', array(
            'model' => $model
        ));
    }
}
