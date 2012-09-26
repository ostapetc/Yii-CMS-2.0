<?php

class m120926_124218_update_pages_types extends DbMigration
{
	public function up()
	{
        $this->execute("UPDATE pages SET type='forum' WHERE id > 8");
	}


	public function down()
	{
		echo "m120926_124218_update_pages_types does not support migration down.\n";
		return false;
	}
}