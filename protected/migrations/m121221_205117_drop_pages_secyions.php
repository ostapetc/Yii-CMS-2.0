<?php

class m121221_205117_drop_pages_secyions extends DbMigration
{
	public function up()
	{
	    $this->dropTable('pages_sections_rels');
        $this->dropTable('pages_sections');
    }


	public function down()
	{
		echo "m121221_205117_drop_pages_secyions does not support migration down.\n";
		return false;
	}
}