<?php

class m120909_151158_alter_sports_rels_add_index_object_model extends DbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `sports_rels` ADD INDEX (  `object_id` ,  `model_id` ) ;");
    }


	public function down()
	{
		echo "m120909_151158_alter_sports_rels_add_index_object_model does not support migration down.\n";
		return false;
	}
}