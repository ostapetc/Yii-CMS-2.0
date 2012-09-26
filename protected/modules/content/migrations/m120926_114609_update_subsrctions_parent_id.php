<?php

class m120926_114609_update_subsrctions_parent_id extends DbMigration
{
	public function up()
	{
        $this->execute("UPDATE pages_sections SET parent_id = 1 WHERE id IN(3,4,5)");
	}


	public function down()
	{
		echo "m120926_114609_update_subsrctions_parent_id does not support migration down.\n";
		return false;
	}
}