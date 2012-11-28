<?php

class m121128_112624_add_source_columns extends DbMigration
{
	public function up()
	{
        $this->execute('
            ALTER TABLE `media_albums`
                ADD COLUMN `source` VARCHAR(50) NULL,
                ADD COLUMN `source_id` VARCHAR(50) NULL;
        ');
	}

	public function down()
	{
		echo "m121128_112624_add_source_columns does not support migration down.\n";
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