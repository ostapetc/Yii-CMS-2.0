<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 14.06.12
 * Time: 15:30
 * To change this template use File | Settings | File Templates.
 */
class DbAuthManager extends CDbAuthManager
{
    public $connectionID = 'db';

    public $itemTable = 'auth_items';

    public $assignmentTable = 'auth_assignments';

    public $itemChildTable = 'auth_items_childs';

    public $defaultRoles = array('guest');
}
