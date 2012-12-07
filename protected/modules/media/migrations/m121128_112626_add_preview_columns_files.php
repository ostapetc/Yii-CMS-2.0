
<?php

class m121128_112626_add_preview_columns_files extends DbMigration
{
	public function up()
	{
        $this->execute('
            ALTER TABLE `media_files`
                ADD COLUMN `preview` VARCHAR(250) NULL,
        ');
	}

	public function down()
	{
    echo "m121128_112626_add_preview_columns_files does not support migration down.\n";
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