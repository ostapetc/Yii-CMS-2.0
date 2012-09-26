<?php

class m120926_112320_update_sections_ids extends DbMigration
{
	public function up()
	{
        $this->execute("update pages_sections set id = 5 where id = 3");
        $this->execute("update pages_sections set id = 4 where id = 2");
        $this->execute("update pages_sections set id = 3 where id = 1");
	}

	public function down()
	{
		echo "m120926_112320_update_sections_ids does not support migration down.\n";
		return false;
	}
}