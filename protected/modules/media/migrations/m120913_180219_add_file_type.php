<?php

class m120913_180219_add_file_type extends DbMigration
{
	public function up()
	{
        $this->execute("
          ALTER TABLE `media_files`
          ADD COLUMN `type`  enum('img','video','audio','doc') NULL
        ");
	}

	public function down()
	{
		echo "m120913_180219_add_file_type does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}