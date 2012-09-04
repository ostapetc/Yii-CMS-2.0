<?php
class DbMigration extends EDbMigration
{
    	public function execute($sql, $params=array(), $verbose=false)
        {
            parent::execute($sql, $params, $verbose);
        }
}